<?php
// ./vendor/bin/phpunit tests
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown(){
            Client::deleteAll();
        }

        function testGetName()
        {
            //Arrange
            $test_id = 33;
            $test_name = "bob";
            $test_last_appointment = "11-14-2011";
            $test_next_appointment = "11-11-3011";
            $test_stylist_id = 10;
            $test_client= new Client($test_id, $test_name, $test_last_appointment, $test_next_appointment, 10);
            //Act
            $result = $test_client->getName();
            //Assert
            $this->assertEquals($test_name, $result);
        }

        function testGetId(){
            $test_client = new Client(null, "bob", "1-11-2111", "2-22-2122", 10);
            $test_client->save();


            $test_client_id = $test_client->getId();
            $result = is_numeric($test_client_id);
            // var_dump($test_client);
            $this->assertEquals(true, $result);
        }
        function testSave(){
            $test_client = new Client(null, "bob", "1-11-2111", "2-22-2122", 10);
            $test_client->save();

            $test_all_clients = Client::getAll();
            $result = $test_all_clients[0];
            // var_dump($test_client);

            $this->assertEquals($test_client, $result);
        }
        function testFind(){
            $test_client = new Client(null, "bob", "1-11-2111", "2-22-2122", 10);
            $test_client2 = new Client(null, "bob", "1-11-2111", "2-22-2122", 10);
            $test_client->save();
            $test_client2->save();
            $test_search_id = $test_client2->getId();

            $result = Client::find($test_search_id);

            $this->assertEquals($test_client2, $result);

        }
        function testDelete(){
            $test_client = new Client(null, "bob", "1-11-2111", "2-22-2122", 10);
            $test_client2 = new Client(null, "bob", "1-11-2111", "2-22-2122", 10);
            $test_client->save();
            $test_client2->save();

            $test_client->delete();
            $result = Client::getAll();

            $this->assertEquals([$test_client2], $result);

        }
        function testUpdate(){
            $test_client = new Client(null, "bob", "1-11-2111", "2-22-2122", 10);
            $test_client->save();
            $test_client_id = $test_client->getId();
            $test_new_name = "barbara";
            $test_new_last_apppointment = "5-5-55";
            $test_new_next_appointment = "9-9-99";

            $test_client->update($test_new_name, $test_new_last_apppointment,  $test_new_next_appointment);
            $test_altered_client = Client::find($test_client_id);
            if(($test_altered_client->getName() == $test_new_name)
            && ($test_altered_client->getLastAppointment() == $test_new_last_apppointment)
            && ($test_altered_client->getNextAppointment() == $test_new_next_appointment))
            {
                $result = true;
            }
            else
            {
                $result = false;
            }

            $this->assertEquals(true, $result);
        }
    }
?>
