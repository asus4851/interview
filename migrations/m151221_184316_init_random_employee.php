<?php

use yii\db\Schema;
use yii\db\Migration;

class m151221_184316_init_random_employee extends Migration
{
    public $tableName = 'employee';
    public $recordsCount = 100;

    public function getFullNameList(){
        $name = [
            'Anton',
            'James',
            'Luci',
            'Lana',
            'Will',
            'Jacob',
            'Michael',
            'Joshua',
            'Matthew',
            'Ethan',
            'Andrew',
            'Daniel',
            'Willia',
            'Joseph',
            'Christopher',
            'Anthony',
            'Ryan',
            'Nicholas',
            'David',
            'Alexander',
            'Tyler',
            'James',
            'John',
            'Dylan',
            'Nathan',
            'Jonathan',
            'Brandon',
            'Samuel',
            'Christian',
            'Benjamin',
            'Zachary',
            'Logan',
            'Jose',
            'Noah',
            'Justin',
            'Elijah',
            'Gabriel',
            'Caleb',
            'Kevin',
            'Austin',
            'Robert',
            'Thomas',
            'Connor',
            'Evan',
            'Aidan',
            'Jack',
            'Luke',
            'Jordan',
            'Angel',
            'Isaiah',
            'Isaac',
            'Jason',
            'Jackson',
            'Hunter',
            'Cameron',
            'Gavin',
            'Mason',
            'Aaron',
            'Juan',
            'Kyle',
            'Charles',
            'Luis',
            'Adam',
            'Brian',
            'Aiden',
            'Eric',
            'Jayden',
            'Alex',
            'Bryan',
            'Sean',
            'Owen',
            'Lucas',
            'Nathaniel',
            'Ian',
            'Jesus',
            'Carlos',
            'Adrian',
            'Diego',
            'Julian',
            'Cole',
            'Ashton',
            'Steven',
            'Jeremiah',
            'Timothy',
            'Chase',
            'Devin',
            'Seth',
            'Jaden',
            'Colin',
            'Cody',
            'Landon',
            'Carter',
            'Hayden',
            'Xavier',
            'Wyatt',
            'Dominic',
            'Richard',
            'Antonio',
            'Jesse',
            'Blake',
            'Sebastian',
            'Miguel',
            'Jake',
            'Alejandro',
            'Patrick',
        ];

        $surname = [
            'Rodriges',
            'Bond',
            'Stranfer',
            'Ray',
            'Smith',
            'Abramson',
            'Adamson',
            'Adderiy',
            'Addington',
            'Adrian',
            'Albertson',
            'Aldridg',
            'Allford',
            'Alsopp',
            'Anderson',
            'Andrews',
            'Archibald',
        ];

        $fullname = [];
        for($i=0;$i<$this->recordsCount;$i++){
            $randName =  $name[rand(0,count($name)-1)]." ".$surname[rand(0,count($surname)-1)];
            array_push($fullname, $randName);
        }
        return $fullname;
    }

    public function getPositionList(){
        return [
            'HR',
            'Team Lead',
            'Junior developer',
            'Middle developer',
            'Project manager',
            'Account manager',
        ];
    }

    public function safeUp()
    {
        $employeeIdList = [];

        $this->insert($this->tableName,[
            'full_name' => 'Jack Paddington',
            'position'  => 'CEO',
            'date'      => '2000-01-01',
            'salary'    => 50000,
            'photo'     => '/photo/boss.jpg'
        ]);
        $employeeIdList[] = Yii::$app->db->lastInsertID;

        $fullNameList = $this->getFullNameList();
        $positionList = $this->getPositionList();

        for($i=0;$i<$this->recordsCount;$i++){
            $this->insert($this->tableName,[
                'full_name' => $fullNameList[rand(0,count($fullNameList)-1)],
                'position'  => $positionList[rand(0,count($positionList)-1)],
                'date'      => date('Y-m-d', time()-rand(0,1E6)),
                'salary'    => rand(5000,45000),
                'parent_id' => $employeeIdList[rand(0,count($employeeIdList)-1)],
                'photo'     => '/photo/employee.jpg'
            ]);
            $employeeIdList[] = Yii::$app->db->lastInsertID;
        }
    }

    public function safeDown()
    {
        $this->truncateTable($this->tableName);
    }
}
