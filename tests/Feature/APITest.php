<?php

namespace Tests\Feature;

use Tests\TestCase;

class APITest extends TestCase
{

    /**
     * Test API calls.
     *
     * @return void
     */
    public function testApiCall()
    {
        foreach ($this->validationDataProvider() as $key => $data) {
            $response = $this->postJson('api/bet', $data["data"]);
            $this->assertTrue($response->content() === $data["result"]);
        }
    }

    /**
     * Returns test data for global valiudation rules
     *
     * @return array
     */
    private function validationDataProvider()
    {
        return [
                [
                   "data" => [
                       "player_id" => 1,
                        "stake_amount" => "2000",
                        "selections" => [
                            [
                                "id" => 1,
                                "odds" => 1.66
                            ]
                        ],
                    ],

                    "result" => '{"error":{"code":11,"messsage":"Insufficient balance"}}',
                ],
                [
                    "data" => [
                        "player_id" => 1,
                         "stake_amount" => "99.9",
                         "selections" => [
                             [
                                 "id" => 1,
                                 "odds" => 1.66
                             ]
                         ],
                     ],

                     "result" => '',
                 ],
                 [
                    "data" => [
                        "player_id" => 2,
                         "stake_amount" => "99.9",
                         "selections" => [
                             [
                                 "id" => 1,
                                 "odds" => 1.66
                             ],
                             [
                                "id" => 2,
                                "odds" => 1.66
                             ],
                             [
                                "id" => 3,
                                "odds" => 1.66
                             ],
                         ],
                     ],

                     "result" => '',
                 ],
                [
                    "data" => [
                        "player_id" => 2,
                        "stake_amount" => "10000.01",
                        "selections" => [
                            [
                                "id" => 1,
                                "odds" => "2.001",
                            ],
                            [
                                "id" => 1,
                                "odds" => "2.001",
                            ]
                        ],
                    ],
                    "result" => '{"errors":[{"code":3,"message":"Maximum stake amount is 10000"},{"code":9,"message":"Maximum win amount is 20000"}],"selections":[{"id":1,"errors":[{"code":8,"message":"Duplicate selection found"}]}]}'
                ],
        ];
    }
}
