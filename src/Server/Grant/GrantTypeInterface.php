<?php

namespace Preferans\Oauth\Server\Grant;

use DateInterval;
use League\OAuth2\Server\CryptKey;
use Phalcon\Http\RequestInterface;
use League\Event\EmitterAwareInterface;
use Preferans\Oauth\Server\ResponseTypeInterface;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

/**
 * Preferans\Oauth\Server\Grant\GrantTypeInterface
 *
 * @package Preferans\Oauth\Server\Grant
 */
interface GrantTypeInterface extends EmitterAwareInterface
{
    /**
     * Set refresh token TTL.
     *
     * @param DateInterval $refreshTokenTTL
     */
    public function setRefreshTokenTTL(DateInterval $refreshTokenTTL);

    /**
     * Return the grant identifier that can be used in matching up requests.
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Respond to an incoming request.
     *
     * @param RequestInterface      $request
     * @param ResponseTypeInterface $responseType
     * @param DateInterval          $accessTokenTTL
     *
     * @return ResponseTypeInterface
     */
    public function respondToAccessTokenRequest(
        RequestInterface $request,
        ResponseTypeInterface $responseType,
        DateInterval $accessTokenTTL
    );

    /**
     * The grant type should return true if it is able to response to an authorization request
     *
     * @param RequestInterface $request
     *
     * @return bool
     */
    public function canRespondToAuthorizationRequest(RequestInterface $request);

    /**
     * If the grant can respond to an authorization request this method should be called to validate the parameters of
     * the request.
     *
     * If the validation is successful an AuthorizationRequest object will be returned. This object can be safely
     * serialized in a user's session, and can be used during user authentication and authorization.
     *
     * @param RequestInterface $request
     *
     * @return AuthorizationRequest
     */
    public function validateAuthorizationRequest(RequestInterface $request);

    /**
     * Once a user has authenticated and authorized the client the grant can complete the authorization request.
     * The AuthorizationRequest object's $userId property must be set to the authenticated user and the
     * $authorizationApproved property must reflect their desire to authorize or deny the client.
     *
     * @param AuthorizationRequest $authorizationRequest
     *
     * @return ResponseTypeInterface
     */
    public function completeAuthorizationRequest(AuthorizationRequest $authorizationRequest);

    /**
     * The grant type should return true if it is able to respond to this request.
     *
     * For example most grant types will check that the $_POST['grant_type'] property matches it's identifier property.
     *
     * @param RequestInterface $request
     *
     * @return bool
     */
    public function canRespondToAccessTokenRequest(RequestInterface $request);

    /**
     * Set the client repository.
     *
     * @param ClientRepositoryInterface $clientRepository
     */
    public function setClientRepository(ClientRepositoryInterface $clientRepository);

    /**
     * Set the access token repository.
     *
     * @param AccessTokenRepositoryInterface $accessTokenRepository
     */
    public function setAccessTokenRepository(AccessTokenRepositoryInterface $accessTokenRepository);

    /**
     * Set the scope repository.
     *
     * @param ScopeRepositoryInterface $scopeRepository
     */
    public function setScopeRepository(ScopeRepositoryInterface $scopeRepository);

    /**
     * Set the path to the private key.
     *
     * @param CryptKey $privateKey
     */
    public function setPrivateKey(CryptKey $privateKey);

    /**
     * Set the encryption key
     *
     * @param string|null $key
     */
    public function setEncryptionKey($key = null);
}
