<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Laravel\Passport\ClientRepository;

class OAuthClientController extends Controller
{
    public function index(Request $request): View
    {
        $clients = $request->user()
            ->oauthApps()
            ->orderByDesc('created_at')
            ->get();

        return view('oauth.clients', [
            'clients' => $clients,
        ]);
    }

    public function store(Request $request, ClientRepository $clientRepository): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'client_type' => ['required', Rule::in(['confidential', 'public_pkce'])],
            'redirect_uris' => ['required', 'string', 'max:4000'],
        ]);

        $redirectUris = $this->parseRedirectUris($data['redirect_uris']);

        Validator::validate(
            ['redirect_uris' => $redirectUris],
            ['redirect_uris' => ['required', 'array', 'min:1'], 'redirect_uris.*' => ['url:strict,http,https']]
        );

        $isConfidential = $data['client_type'] === 'confidential';

        $client = $clientRepository->createAuthorizationCodeGrantClient(
            $data['name'],
            $redirectUris,
            $isConfidential,
            $request->user(),
        );

        return redirect()
            ->route('oauth.clients.index')
            ->with('status', 'OAuth client berhasil dibuat.')
            ->with('created_client', [
                'id' => $client->id,
                'name' => $client->name,
                'secret' => $client->plainSecret,
                'type' => $isConfidential ? 'Confidential' : 'Public PKCE',
            ]);
    }

    public function destroy(Request $request, string $clientId): RedirectResponse
    {
        $client = $request->user()
            ->oauthApps()
            ->where('id', $clientId)
            ->firstOrFail();

        $client->forceFill([
            'revoked' => true,
        ])->save();

        $client->tokens()->update([
            'revoked' => true,
        ]);

        return redirect()
            ->route('oauth.clients.index')
            ->with('status', 'OAuth client berhasil di-revoke.');
    }

    /**
     * @return string[]
     */
    private function parseRedirectUris(string $rawRedirectUris): array
    {
        $candidateUris = preg_split('/[\r\n,]+/', $rawRedirectUris) ?: [];

        return array_values(array_filter(array_map(static fn(string $uri): string => trim($uri), $candidateUris)));
    }
}
