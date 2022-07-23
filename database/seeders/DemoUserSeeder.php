<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Image;
use App\Models\ServiceRegion;
use App\Models\DivisionSection;
use App\Models\Position;
use App\Models\Role;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role as ModelsRole;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // return 
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');
        User::firstOrCreate(
            [
                'email' => "alan@ocd.gov.ph"
            ],
            [
                'firstname' => "Paolo Jonas",
                'lastname' => "Alan",
                'serreg_id' => "1",
                'pos_id' => "1",
                'divsec_id' => "1",
                'email_verified_at' => "2022-01-01 08:00:00",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'email_verified_at' => $timestamp,
                'status' => "1",
                "approver_id" => "1"
            ]
        );

        User::firstOrCreate(
            [
                'email' => "valdehueza@ocd.gov.ph"
            ],
            [
                'firstname' => "Karen",
                'lastname' => "Valdehueza",
                'serreg_id' => "1",
                'pos_id' => "2",
                'divsec_id' => "2",
                'email_verified_at' => "2022-01-01 08:00:00",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'email_verified_at' => $timestamp,
                'status' => "1",
                "approver_id" => "2"


            ]
        );



        User::firstOrCreate(
            [
                'email' => "deza@ocd.gov.ph"
            ],
            [
                'firstname' => "Julius",
                'lastname' => "Deza",
                'serreg_id' => "3",
                'pos_id' => "3",
                'divsec_id' => "3",
                'email_verified_at' => "2022-01-01 08:00:00",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'email_verified_at' => $timestamp,
                'status' => "1",
                "approver_id" => "1"


            ]
        );

        User::firstOrCreate(
            [
                'email' => "balajadia@ocd.gov.ph"
            ],
            [
                'firstname' => "Emanuel",
                'lastname' => "Balajadia",
                'serreg_id' => "4",
                'pos_id' => "1",
                'divsec_id' => "1",
                'email_verified_at' => "2022-01-01 08:00:00",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'email_verified_at' => $timestamp,
                'status' => "1",
                "approver_id" => "1"


            ]
        );

        User::firstOrCreate(
            [
                'email' => "guest@ocd.gov.ph"
            ],
            [
                'firstname' => "Gwen",
                'lastname' => "Stacey",
                'email_verified_at' => "2022-01-01 08:00:00",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'email_verified_at' => $timestamp,
                'status' => "1",
                "approver_id" => "1"


            ]
        );



        User::firstOrCreate(
            [
                'email' => "dev@ocd.gov.ph"
            ],
            [
                'firstname' => "Telmo",
                'lastname' => "Solutions",
                'serreg_id' => "1",
                'pos_id' => "2",
                'divsec_id' => "2",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'email_verified_at' => $timestamp,
                'status' => "1",
                "approver_id" => "2"


            ]
        );

       




        $superAdminImage = new Image(['url' => 'https://scontent.fceb6-1.fna.fbcdn.net/v/t1.6435-9/180180406_115570697340043_7681303704692535162_n.jpg?_nc_cat=111&ccb=1-5&_nc_sid=09cbfe&_nc_ohc=pHJcLe-skEUAX-M5E1v&_nc_ht=scontent.fceb6-1.fna&oh=00_AT8RzPk77yjbdTXhZVWUUFXT-ZtERSltCr3dp1rAz4VvrA&oe=628D6494']);
        $adminImage = new Image(['url' => 'https://scontent.fceb6-1.fna.fbcdn.net/v/t1.6435-9/104431299_954280191652278_352143994058889201_n.jpg?_nc_cat=105&ccb=1-5&_nc_sid=09cbfe&_nc_ohc=RALbAda6L6cAX8tdYIY&_nc_ht=scontent.fceb6-1.fna&oh=00_AT-HGG19yJr3ztrHx7grMkJnkiopZlg35orKWC67LscEuw&oe=628E72A3']);

        $superAdministrator = User::find(1);
        $administrator = User::find(2);
        $technicalWorkingGroup = User::find(3);
        $planningFocalOfficer = User::find(4);
        $guest = User::find(5);
        $developer = User::find(6);
        $administrator2 = User::find(7);
        $planningFocalOfficer2 = User::find(8);
        $planningFocalOfficer3 = User::find(9);

        $superAdministrator->profilePhoto()->save($superAdminImage);
        $administrator->profilePhoto()->save($adminImage);

        $superAdministrator->assignRole('Super Administrator');
        $administrator->assignRole('Administrator');
        $technicalWorkingGroup->assignRole('Technical Working Group');
        $planningFocalOfficer->assignRole('Administrator');
        $guest->assignRole('Guest');
        $developer->assignRole('Developer');
        // $administrator2->assignRole('Administrator');
        // $planningFocalOfficer2->assignRole('Planning Focal/Officer');
        // $planningFocalOfficer3->assignRole('Planning Focal/Officer');

        $this->newSeeder();
    }




    public function newSeeder()
    {
        $index = 0;
        $users = array(
            array("firstname" => "Gia Mae", "middlename" => "Realis", "lastname" => "Resaba", "extension" => "", "email" => "giamaeresaba@gmail.com", "role" => "Technical Working Group", "service_region" => "Policy Development and Planning Service", "division" => "PPPDMD", "position" => "Civil Defense Officer II"),
            array("firstname" => "Fren Elias", "middlename" => "De Veyra", "lastname" => "Malinao", "extension" => "", "email" => "frenelias@gmail.com", "role" => "Planning Focal/Officer", "service_region" => "Region XIII", "division" => "DRRMD", "position" => "Technical Staff"),
            array("firstname" => "Julius Ismael", "middlename" => "N/A", "lastname" => "Deza", "extension" => "", "email" => "julius.deza@ocd.gov.ph", "role" => "Technical Working Group", "service_region" => "Operations Service", "division" => "ICTD", "position" => "Computer Maintenance Technologist I"),
            array("firstname" => "Karen Kaye", "middlename" => "Gargantiel", "lastname" => "Caballero", "extension" => "", "email" => "karenkaye.caballero@ocd.gov.ph", "role" => "Technical Working Group", "service_region" => "Operations Service", "division" => "ROCD", "position" => "CIVIL DEFENSE OFFICER III"),
            array("firstname" => "Mary May", "middlename" => "S", "lastname" => "Baclig", "extension" => "", "email" => "mmsolivabaclig@gmail.com", "role" => "Planning Focal/Officer", "service_region" => "Region II", "division" => "PDPS", "position" => "Civil Defense Officer III"),
            array("firstname" => "CHRISTIAN KARL", "middlename" => "TACTAC", "lastname" => "IBAÃEZ", "extension" => "", "email" => "ibanezkarl000@gmail.com", "role" => "Encoder", "service_region" => "Region II", "division" => "PDPS", "position" => "TECHNICAL SUPPORT"),
            array("firstname" => "Wilmina", "middlename" => "Ancheta", "lastname" => "Cabrera", "extension" => "", "email" => "cabrera.wilmina@gmail.com", "role" => "Technical Working Group", "service_region" => "Executive Office", "division" => "IMEO", "position" => "Technical Support Staff"),
            array("firstname" => "Romina ", "middlename" => "Baldonado", "lastname" => "Marasigan", "extension" => "", "email" => "ocda.ocd@gmail.com", "role" => "Technical Working Group", "service_region" => "Executive Office", "division" => "OCDA", "position" => "Public Relations Officer III"),
            array("firstname" => "Myrabeth", "middlename" => "Escobar", "lastname" => "Alicias", "extension" => "", "email" => "mealicias@gmail.com", "role" => "Technical Working Group", "service_region" => "Capacity Building and Training Service", "division" => "OD", "position" => "Civil Defense Officer III"),
            array("firstname" => "Jamelah", "middlename" => "", "lastname" => "Josr", "extension" => "", "email" => "jamelahkayjose@gmail.com", "role" => "Technical Working Group", "service_region" => "Executive Office", "division" => "OCD", "position" => "Technical Support "),
            array("firstname" => "Al-Emran", "middlename" => "Arakan", "lastname" => "Asani", "extension" => "", "email" => "alemran.asani@ocd.gov.ph", "role" => "Technical Working Group", "service_region" => "Region IX", "division" => "PDPS", "position" => "Civil Defense Officer II"),
            array("firstname" => "Marc Rembrandt", "middlename" => "Prado", "lastname" => "Victore", "extension" => "", "email" => "marc_victore@yahoo.com", "role" => "Planning Focal/Officer", "service_region" => "Region IV-B", "division" => "PS", "position" => "Chief, Planning Section"),
            array("firstname" => "JUDY MAE", "middlename" => "MORENO", "lastname" => "ADALIN", "extension" => "", "email" => "brinx.adalin0728@gmail.com", "role" => "Planning Focal/Officer", "service_region" => "Region II", "division" => "DRRMD", "position" => "ADOF IV"),
            array("firstname" => "Richard", "middlename" => "Castillo", "lastname" => "Santos", "extension" => "", "email" => "richard.santos@ocd.gov.ph", "role" => "Planning Focal/Officer", "service_region" => "Region III", "division" => "PDPS", "position" => "Civil Defense Officer III"),
            array("firstname" => "April Rose Anne ", "middlename" => "Sanchez", "lastname" => "Elmedulan", "extension" => "", "email" => "aprilroseannesanchez060713@gmail.com", "role" => "Planning Focal/Officer", "service_region" => "Region XIII", "division" => "PDPS", "position" => "Technical Staff"),
            array("firstname" => "David Ison ", "middlename" => "Lorenzo", "lastname" => "Edmalin", "extension" => "", "email" => "david.edmalin@ocd.gov.ph", "role" => "Technical Working Group", "service_region" => "Operations Service", "division" => "24/7 OpCen", "position" => "Civil Defense Officer I"),
            array("firstname" => "Wilmina", "middlename" => "Ancheta", "lastname" => "Cabrera", "extension" => "", "email" => "cabrera.wilmina@gmail.com", "role" => "Technical Working Group", "service_region" => "Executive Office", "division" => "IMEO", "position" => "Technical Support Staff"),
            array("firstname" => "Ricardo", "middlename" => "Suyat", "lastname" => "Mago", "extension" => "Jr", "email" => "magojr.jhun@gmail.com", "role" => "Technical Working Group", "service_region" => "Executive Office", "division" => "OCDA", "position" => "Technical Support"),
            array("firstname" => "Janine", "middlename" => "Tomines", "lastname" => "Casimiro", "extension" => "", "email" => "janinetcasimiro@gmail.com", "role" => "Budget Administrator", "service_region" => "Administrative and Financial Management Service", "division" => "FMD", "position" => "Administrative Officer IV"),
            array("firstname" => "Rachelle Grace", "middlename" => "De Guzman", "lastname" => "Cacas", "extension" => "", "email" => "cordillerapdpsocd@gmail.com", "role" => "Technical Working Group", "service_region" => "Cordillera Administrative Region", "division" => "FMD", "position" => "Civil Defense Officer II"),
            array("firstname" => "Michael", "middlename" => "Maido", "lastname" => "LosbaÃ±es", "extension" => "", "email" => "michael.losbanes@gmail.com", "role" => "Technical Working Group", "service_region" => "Administrative and Financial Management Service", "division" => "PMD", "position" => "Administrative Officer II"),
            array("firstname" => "Louis Jonas", "middlename" => "Mata", "lastname" => "Lauraya", "extension" => "", "email" => "lauraya.ocsppmo@gmail.com", "role" => "Planning Focal/Officer", "service_region" => "Region V", "division" => "PDPS", "position" => "CHIEF"),
            array("firstname" => "VERNA", "middlename" => "CAVAN", "lastname" => "VIEJO", "extension" => "", "email" => "viejoverna@gmail.com", "role" => "Technical Working Group", "service_region" => "Administrative and Financial Management Service", "division" => "GSD-CDS", "position" => "ADMIN OFFICER I"),
            array("firstname" => "Janice", "middlename" => "Montes", "lastname" => "Padagdag", "extension" => "", "email" => "janice.padagdag0820@gmail.com", "role" => "Planning Focal/Officer", "service_region" => "Region VII", "division" => "PDPS", "position" => "Civil Defense Officer II"),
            array("firstname" => "MELLY JOY ", "middlename" => "FALCULAN ", "lastname" => "FAJILAGMAGO ", "extension" => "", "email" => "mellyjoy.fajilagmago@ocd.gov.ph", "role" => "Technical Working Group", "service_region" => "Region IV-B", "division" => "AFMS", "position" => "Civil Defense officer II"),
            array("firstname" => "Diane", "middlename" => "Man-on", "lastname" => "Truz", "extension" => "", "email" => "ocd7acctg@gmail.com", "role" => "Budget Administrator", "service_region" => "Region VII", "division" => "AFMS", "position" => "Civil Defense Office II"),
            array("firstname" => "Kelvin John", "middlename" => "Hipolito", "lastname" => "Reyes", "extension" => "NA", "email" => "kelvinjohnreyespogi@gmail.com", "role" => "Plans Administrator", "service_region" => "Region IV-A", "division" => "PPS", "position" => "Chief"),
            array("firstname" => "KAREN MARIE", "middlename" => "ONDIN", "lastname" => "VALDEHUEZA", "extension" => "NA", "email" => "karenvaldehueza321@gmail.com", "role" => "Budget Administrator", "service_region" => "Administrative and Financial Management Service", "division" => "FMD", "position" => "Administrative Officer V"),
            array("firstname" => "Denise Anne", "middlename" => "", "lastname" => "Untalan", "extension" => "", "email" => "dennuntalanxx@gmail.com", "role" => "Budget Administrator", "service_region" => "Administrative and Financial Management Service", "division" => "FMD", "position" => "Administrative Assistant II "),
            array("firstname" => "MENCHIE", "middlename" => "Gonzales", "lastname" => "Ganzon", "extension" => "", "email" => "menchie.ganzon@ocd.gov.ph", "role" => "Budget Administrator", "service_region" => "Region IV-A", "division" => "PPS", "position" => "Assistant chief"),
            array("firstname" => "Rachelle Grace", "middlename" => "De Guzman", "lastname" => "Cacas", "extension" => "", "email" => "cordillerapdpsocd@gmail.com", "role" => "Technical Working Group", "service_region" => "Cordillera Administrative Region", "division" => "PDPS", "position" => "Civil Defense Officer II"),
            array("firstname" => "AMADO", "middlename" => "MAZO", "lastname" => "POSAS", "extension" => "", "email" => "odamasasop@yahoo.com.ph", "role" => "Super Administrator", "service_region" => "Caraga", "division" => "AFMS", "position" => "CDO IV"),
            array("firstname" => "Ferdinand ", "middlename" => "Alamo", "lastname" => "Tamulto", "extension" => "", "email" => "tamulto.f0504@gmail.com", "role" => "Technical Working Group", "service_region" => "Cordillera Administrative Region", "division" => "PDPS", "position" => "Civil Defense Officer III"),
            array("firstname" => "Julleah Sheena", "middlename" => "", "lastname" => "Narag", "extension" => "", "email" => "sheenanarag20@gmail.com", "role" => "Technical Working Group", "service_region" => "National Capital Region", "division" => "PDPS", "position" => "Technical Support"),
            array("firstname" => "Paolo Jesus", "middlename" => "Morris", "lastname" => "Roxas", "extension" => "I", "email" => "paolojesus.roxas@ocd.gov.ph", "role" => "Planning Focal/Officer", "service_region" => "National Capital Region", "division" => "PDPS", "position" => "Civil Defense Officer I"),
            array("firstname" => "Alexa Mae ", "middlename" => "Segovia", "lastname" => "San Esteban", "extension" => "", "email" => "alexamae1202@gmail.com", "role" => "Encoder", "service_region" => "Region III", "division" => "OS", "position" => "OS Staff / Contract of Service "),
        );

        foreach ($users as $user) {
            echo $index;
            // model_has_roles
            // echo ServiceRegion::where('accronym', $user['service_region'])->first();
            // echo $user['service_region'];git s
            $timestamp = Carbon::now()->format('Y-m-d H:i:s');
            $user['service_region'] = ServiceRegion::where('service_region', $user['service_region'])->first()->id;
            $user['division'] = DivisionSection::where('accronym', $user['division'])->first()->id;
            $user['position'] = Position::where('job_title', $user['position'])->first()->id;
            $user['role'] = Role::where("name", $user['role'])->first()->id;



            $tao = User::firstOrCreate(["email" => $user["email"],], [
                "firstname" => $user["firstname"],
                "middlename" => $user["middlename"],
                "lastname" => $user["lastname"],
                "ext" => $user["extension"],
                "divsec_id" => $user["division"],
                "serreg_id" => $user["service_region"],
                "pos_id" => $user["position"],
                'email_verified_at' => $timestamp,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'email_verified_at' => $timestamp,
                'status' => "1",
                "approver_id" => "1"
            ]);

            //check if model_has_roles exists
            $has_role_exists = DB::table('model_has_roles')->where(
                [
                    "role_id" => $user['role'],
                    "model_id" => $tao->id,
                    "model_type" => 'App\Models\User',
                ]
            )->first();

            if (!$has_role_exists) {
                //create if not
                DB::table('model_has_roles')->insert([
                    "role_id" => $user['role'],
                    "model_id" => $tao->id,
                    "model_type" => 'App\Models\User',
                ]);
            }

            $index++;
        }
    }
}
