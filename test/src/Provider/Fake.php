<?php

namespace League\OAuth2\Client\Test\Provider;

use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Http\Message\ResponseInterface;

class Fake extends AbstractProvider
{
    use BearerAuthorizationTrait;

    private $accessTokenMethod = 'POST';

    public function getBaseAuthorizationUrl()
    {
        return 'http://example.com/oauth/authorize';
    }

    public function getBaseAccessTokenUrl()
    {
        return 'http://example.com/oauth/token';
    }

    public function getUserDetailsUrl(AccessToken $token)
    {
        return 'http://example.com/oauth/user';
    }

    protected function getDefaultScopes()
    {
        return ['test'];
    }

    public function setAccessTokenMethod($method)
    {
        $this->accessTokenMethod = $method;
    }

    public function getAccessTokenMethod()
    {
        return $this->accessTokenMethod;
    }

    protected function prepareUserDetails(array $response, AccessToken $token)
    {
        return new Fake\User($response);
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (!empty($data['error'])) {
            throw new IdentityProviderException($data['error'], $data['code'], $data);
        }
    }
}
