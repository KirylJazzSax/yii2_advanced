<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.10.2019
 * Time: 20:47
 */

namespace api\tests\api;


use api\tests\ApiTester;
use common\fixtures\PostFixture;
use common\fixtures\TokenFixture;
use common\fixtures\UserFixture;

class PostCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'post' => [
                'class' => PostFixture::class,
                'dataFile' => codecept_data_dir() . 'post.php'
            ],
            'token' => [
                'class' => TokenFixture::class,
                'dataFile' => codecept_data_dir() . 'token.php'
            ]
        ]);
    }

    public function index(ApiTester $I)
    {
        $I->sendGET('/posts');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            ['tittle' => 'My First Post'],
            ['tittle' => 'Another User Post']
        ]);
        $I->seeHttpHeader('X-Pagination-Total-Count', 2);
    }

    public function view(ApiTester $I)
    {
        $I->sendGET('/posts/1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'tittle' => 'My First Post'
        ]);
    }

    public function viewNotFound(ApiTester $I)
    {
        $I->sendGET('/posts/15');
        $I->seeResponseCodeIs(404);
    }

    public function readonly(ApiTester $I)
    {
        $I->sendPATCH('/posts/15', [
            'tittle' => 'New post',
        ]);
        $I->seeResponseCodeIs(405);
    }

    public function search(ApiTester $I)
    {
        $I->sendGET('/posts?s[tittle]=First');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            ['tittle' => 'My First Post']
        ]);
        $I->dontSeeResponseContainsJson([
            ['tittle' => 'Another User Post']
        ]);
        $I->seeHttpHeader('X-Pagination-Total-Count', 1);
    }
}