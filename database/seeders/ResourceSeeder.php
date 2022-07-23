<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResourceAccount;
use App\Models\Resources;
use App\Models\ResourceAccess;

class ResourceSeeder extends Seeder
{


   

    public function run()
    {
        $counting = 0;
        $resourceAccount = array(
            ["username" => "ocdpbmis@gmail.com", "password" => "bqcBJqE4BeTrf7U2", "role" => '1', "creator_id" => '1',
             "access" => array(
                    [
                        "title" => "Super Admin PBMIS Self-Service Videos",
                        "link" => "https://www.youtube.com/playlist?list=PL9YaLJE-4rSPre4vdCjH65FqWAZd2PbwY",
                        "description" => "",
                        "status" => "vid",
                    ]
                )
            ],
            ["username" => "admn.ocd@gmail.com", "password" => "E4BeTrf8", "role" => '2', "creator_id" => '1',
                "access" => array(
                    [
                        "title" => "Admin PBMIS Self-Service Videos",
                        "link" => "https://www.youtube.com/playlist?list=PLi9S2Xu2eDvwUw8vgKRN56qplZD5bJ1sA",
                        "description" => "",
                        "status" => "vid",
                    ],
                    
    
                )
            ],
            ["username" => "twg.ocd@gmail.com", "password" => "8ukM4tnb", "role" => '3', "creator_id" => '1',
                "access" => array(
                    [
                        "title" => "TWG PBMIS Self-Service Videos",
                        "link" => "https://www.youtube.com/playlist?list=PLvDbrvmaVK4j5MwWI0FPrxQvr4o-O7WiX",
                        "description" => "",
                        "status" => "vid",
                    ],
                )
            ],
            ["username" => "tfo.ocd@gmail.com", "password" => "1mjwmU26", "role" => '4', "creator_id" => '1',
                "access" => array(
                    [
                        "title" => "TFO PBMIS Self-Service Videos",
                        "link" => "https://www.youtube.com/playlist?list=PL_ZrTbcoc-NDExbAXG7eZMwptA3qf5DyB",
                        "description" => "",
                        "status" => "vid",
                    ],
                )
            ],
        );

        $resourcexx = array(
        [
            "access" => array(
                ["id" => 1] 
            ),
            "title" => "How to Create, Edit & Delete Allotment Class",
            "link" => "https://youtu.be/mHX0WF1wDXQ",
            "description" => "",
            "status" => "vid",
        ],
        [   
            "access" => array(
                ["id" => 1] 
            ),
            "title" => "How to Create & Delete Categorized Accounts",
            "link" => "https://youtu.be/0xxMGRS2wPw",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1] 
            ),
            "title" => "How to Create, Edit & Delete Chart of Accounts",
            "link" => "https://youtu.be/HkYnKXDak5s",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1],
            ),
            "title" => "How to Create, Edit & Delete Default Item of Requirement",
            "link" => "https://youtu.be/JKTn68r6cbc",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1],
                ["id" => 2],
            ),
            "title" => "How to Create, Edit & Delete Default PAPS",
            "link" => "https://youtu.be/0Svu3dmCx2k",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
            ),
            "title" => "How to Create, Edit & Division Section",
            "link" => "https://youtu.be/FRbIYF9psDI",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1],
            ),
            "title" => "How to Create, Edit & Delete Fund Chargeability",
            "link" => "https://youtu.be/J4p-5pZtiZM",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1] 
            ),
            "title" => "How to Create, Edit & Delete  KDP",
            "link" => "https://youtu.be/J_M3O3hKyoc",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1] 
            ),
            "title" => "How to Create, Edit & Delete Major Final Output",
            "link" => "https://youtu.be/VByp0Xd88Xs",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1], 
                ["id" => 2]
            ),
            "title" => "How to Create, Edit & Delete PAP Tagging",
            "link" => "https://youtu.be/RQEQacKV35E",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 2] 
            ),
            "title" => "How to Create, Edit & Delete Performance  Measure",
            "link" => "https://youtu.be/6hgHhFDC_dY",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
            ),
            "title" => "How to Create, Edit & Delete Position",
            "link" => "https://youtu.be/rKIpKDEM_dI",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1]
            ),
            "title" => "How to Create, Edit & Delete Priority Class",
            "link" => "https://youtu.be/FRbIYF9psDI",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1]
            ),
            "title" => "How to Create, Edit & Delete Procurement Mode",
            "link" => "https://youtu.be/jVURApQhNiE",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
            ),
            "title" => "How to Create, Edit & Delete Service Region",
            "link" => "https://youtu.be/0Svu3dmCx2k",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1]
            ),
            "title" => "How to Create, Edit & Delete Stages",
            "link" => "https://youtu.be/rKIpKDEM_dI",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1],
                ["id" => 2]
            ),
            "title" => "How to Create, Edit & Delete Default SUB-PAPS",
            "link" => "https://youtu.be/6hgHhFDC_dY",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1],
                ["id" => 2]
            ),
            "title" => "How to Create, Edit & Delete Target Sector",
            "link" => "https://youtu.be/BpQ9QthmnOo",
            "description" => "",
            "status" => "vid",
        ],
        [
            "access" => array(
                ["id" => 1],
                ["id" => 2]
            ),
            "title" => "How to Edit MFO's",
            "link" => "https://youtu.be/ok4h6rJPpq0",
            "description" => "",
            "status" => "vid",
        ],
    );
        for($i = 0; $i < count($resourceAccount); $i++){
            echo "\n Creating Resource account number: ".($i + 1)."\n";
            $resource = new ResourceAccount();
            $resource->username = $resourceAccount[$i]["username"];
            $resource->password = $resourceAccount[$i]["password"];
            $resource->role_id = $resourceAccount[$i]["role"];
            $resource->creator_id = $resourceAccount[$i]["creator_id"];
            $resource->save();
            for($x = 0; $x < count($resourceAccount[$i]['access']);$x++){
                    if($resource){
                        $res = new Resources();
                        $res->title = $resourceAccount[$i]['access'][$x]['title'];
                        $res->link = $resourceAccount[$i]['access'][$x]['link'];
                        $res->description = $resourceAccount[$i]['access'][$x]['description'];
                        $res->status = $resourceAccount[$i]['access'][$x]['status'];
                        $res->save();
                        if($res){
                            $access = new ResourceAccess();
                            $access->resource_id = $res->id;
                            $access->access_id = $resource->id;
                            $access->save();
                        }
                      
                    }
            }
        }
        for($i = 0; $i < count($resourcexx); $i++){
                $res = new Resources();
                $res->title = $resourcexx[$i]['title'];
                $res->link = $resourcexx[$i]['link'];
                $res->description = $resourcexx[$i]['description'];
                 $res->status = $resourcexx[$i]['status'];
                 $res->save();
                 if( $res){
                     for($x = 0; $x < count($resourcexx[$i]["access"]); $x++){
                        $access = new ResourceAccess();
                        $access->resource_id = $res->id;
                        $access->access_id = $resourcexx[$i]["access"][$x]['id'];
                        $access->save();
                     }
                 }
        }
    }
}
