<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require 'phpSpreadsheet/autoload.php';

Class MembershipController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        // var_dump($this->request);die;
        $this->loadComponent('Csrf');
        $this->loadComponent('RequestHandler');
        $this->loadComponent("GYMFunction");
    }

    public function add()
    {
        $this->set("membership", null);
        $this->set("edit", false);
        $this->set("title", __("Add Membership"));
        $catgories = $this->Membership->Category->find("list", ["keyField" => "id", "valueField" => "name"]);
        $catgories = $catgories->toArray();

        $classes = $this->Membership->ClassSchedule->find("list", ["keyField" => "id", "valueField" => "class_name"])->toArray();
        $this->set("classes", $classes);

        $installment_plan = $this->Membership->Installment_Plan->find("list", ["keyField" => "id", "valueField" => "concatenated"]); //Merging two table column ["col1","col2"]
        $installment_plan->select(['id',
            'concatenated' => $installment_plan->func()->concat([
                'number' => 'literal',
                ' ',
                'duration' => 'literal'
            ])
        ]);  // adding space between two column cakephp way.

        $installment_plan = $installment_plan->toArray();

        $discount_id = $this->Membership->Discount_Id->find("list", ["keyField" => "id", "valueField" => "concatenated"]); //Merging two table column ["col1","col2"]
        $discount_id->select(['id',
            'concatenated' => $discount_id->func()->concat([
                'number' => 'literal',
                ' ',
                'type' => 'literal'
            ])
        ]);  // adding space between two column cakephp way.

        $discount_id = $discount_id->toArray();

        $this->set('discount_id', $discount_id);
        $this->set('installment_plan', $installment_plan);
        $this->set('categories', $catgories);
        $membership = $this->Membership->newEntity();
        if ($this->request->is("post")) {
            $ext = $this->GYMFunction->check_valid_extension($this->request->data('gmgt_membershipimage')['name']);
            if ($ext != 0) {
                $new_name = $this->GYMFunction->uploadImage($this->request->data["gmgt_membershipimage"]);
                $this->request->data["gmgt_membershipimage"] = $new_name;
                $this->request->data["created_date"] = date("Y-m-d");
                $this->request->data["membership_class"] = json_encode($this->request->data["membership_class"]);


                if (!isset($this->request->data["limit_days"])) {
                    $this->request->data["limit_days"] = null;
                    $this->request->data["limitation"] = null;
                }
                $membership = $this->Membership->patchEntity($membership, $this->request->data());

                if ($this->Membership->save($membership)) {
                    $this->Flash->success(__("Success! Record Saved Successfully"));
                    return $this->redirect(["action" => "membershipList"]);
                } else {
                    $this->Flash->error(__("Error! There was an error while saving,Please try again later."));
                }
            } else {
                $this->Flash->error(__("Invalid File Extension, Please Retry."));
                return $this->redirect(["action" => "add"]);
            }
        }
    }

    public function membershipList()
    {
        $membership_data = $this->Membership->find("all")->toArray();
        // $membership_data = $this->Membership->find("all",array('contain'=>array('Installment_Plan')))->toArray();
        // $membership_data = $this->Membership->find()->contain([
        // 'Installment_Plan'=>function($q){
        // return $q
        // ->select(['duration'])
        // ->where(['Installment_Plan.id'=>2]);
        // }
        // ])->toArray();
        // $membership_data = $this->Membership->find()->contain(['Installment_Plan'])->select(['Membership.*','Installment_Plan.duration'])->hydrate(false);
        // $membership_data = $this->Membership->find();
        // $membership_data = $membership_data->contain(['Installment_Plan'])->select(["Membership.membership_label",'duration' => $membership_data->func()->concat(['number' => 'literal',' ','duration' => 'literal'])])->hydrate(false);


        $this->set("membership_data", $membership_data);
    }

    public function editMembership($id)
    {
        $this->set("edit", true);
        $this->set("membership", null);
        $this->set("title", __("Edit Membership"));

        $classes = $this->Membership->ClassSchedule->find("list", ["keyField" => "id", "valueField" => "class_name"])->toArray();
        $this->set("classes", $classes);

        $membership_data = $this->Membership->get($id)->toArray();
        $catgories = $this->Membership->Category->find("list", ["keyField" => "id", "valueField" => "name"]);
        $catgories = $catgories->toArray();

        $installment_plan = $this->Membership->Installment_Plan->find("list", ["keyField" => "id", "valueField" => "concatenated"]); //Merging two table column ["col1","col2"]
        $installment_plan->select(['id',
            'concatenated' => $installment_plan->func()->concat([
                'number' => 'literal',
                ' ',
                'duration' => 'literal'
            ])
        ]);  // adding space between two column cakephp way.

        $installment_plan = $installment_plan->toArray();

        $discount_id = $this->Membership->Discount_Id->find("list", ["keyField" => "id", "valueField" => "concatenated"]); //Merging two table column ["col1","col2"]
        $discount_id->select(['id',
            'concatenated' => $discount_id->func()->concat([
                'number' => 'literal',
                ' ',
                'type' => 'literal'
            ])
        ]);  // adding space between two column cakephp way.

        $discount_id = $discount_id->toArray();

        $membership_class = json_decode($membership_data["membership_class"]);


        $this->set('discount_id', $discount_id);
        $this->set('installment_plan', $installment_plan);
        $this->set('categories', $catgories);
        $this->set("membership_data", $membership_data);
        $this->set("membership_class", $membership_class);

        if ($this->request->is("post")) {
            $ext = $this->GYMFunction->check_valid_extension($this->request->data('gmgt_membershipimage')['name']);
            if ($ext != 0) {
                $row = $this->Membership->get($id);
                if ($this->request->data['gmgt_membershipimage']['name'] != "") {
                    $new_name = $this->GYMFunction->uploadImage($this->request->data["gmgt_membershipimage"]);
                    $this->request->data["gmgt_membershipimage"] = $new_name;
                }
                if (!isset($this->request->data["limit_days"])) {
                    $this->request->data["limit_days"] = null;
                    $this->request->data["limitation"] = null;
                }
                $this->request->data["membership_class"] = json_encode($this->request->data["membership_class"]);

                $membership = $this->Membership->patchEntity($row, $this->request->data);
                if ($this->Membership->save($membership)) {
                    $this->Flash->success(__("Success! Record Updated Successfully"));
                    return $this->redirect(["action" => "membershipList"]);
                } else {
                    $this->Flash->error(__("Error! There was an error while updating,Please try again later."));
                }
            } else {
                $this->Flash->error(__("Invalid File Extension, Please Retry."));
                return $this->redirect(["action" => "edit-membership", $id]);
            }
        }
        $this->render("add");
    }

    public function viewActivity($mid)
    {

        $membership_activity = $this->Membership->get($mid);
        $this->set("membership_name", $membership_activity->membership_label);
        $users = TableRegistry::get("GymMember");
        $usersArr  = $users->find('all',['fields'=>['member_id','first_name','last_name']])->where(["selected_membership"=>$mid])->hydrate(false)->toArray();
        $users = [];
        $picArr = [];
        $sDate = $_POST['sDate'];
        $eDate = $_POST['eDate'];


        for($i=0;$i<sizeof($usersArr);$i++){
            $name = $usersArr[$i]["first_name"]." ". $usersArr[$i]["last_name"];
            array_push($picArr, $usersArr[$i]["member_id"]);
            array_push($users, [$usersArr[$i]["member_id"],$name]);
        }
        $usersArray = $users;
        $this->set("usersArray", $usersArray);

        if ($this->request->is("post")) {

            require_once("tad-php/add.php");
            date_default_timezone_set('Asia/Dhaka');

            $totalMembers = sizeof($usersArray);


            /*$absentMembers = 0;
            $presentUsers = [];
            for ($i = 0; $i < sizeof($picArr); $i++) {
                $user_info = $tad->get_att_log(['pin' => $picArr[$i]]);
                $t = $user_info->filter_by_date(['start' => $sDate, 'end' => $eDate]);
                if ($t->is_empty_response()) {
                    $presentUsers[] = array($picArr[$i] => array());
                    $absentMembers = $absentMembers+1;
                } else {
                    $t = $user_info->to_array();
                    if (!array_key_exists('PIN', $t['Row'])) {
                        $arr = reset($t);
                        $presentUsers[] = array($picArr[$i] => $arr);
                    } else {
                        $arr = $t['Row'];
                        $presentUsers[] = array($picArr[$i] => $arr);
                    }
                }
            }

            $presentMembers = $totalMembers - $absentMembers;
            $this->set("totalMembers",$totalMembers);
            $this->set("presentMembers",$presentMembers);
            $this->set("absentMembers",$absentMembers);*/

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('C1', 'Date');
            $sheet->setCellValue('D1', 'Time');
            $flagCell = 1;
            echo "<table border='1'>";
            echo "<thead><th>ID</th> <th>Name</th> <th>Date</th><th>Time</th></thead>";
            for ($i = 0; $i < sizeof($picArr); $i++) {
                $user_info = $tad->get_att_log(['pin' => $picArr[$i]]);
                $t = $user_info->filter_by_date(['start' => $sDate, 'end' => $eDate]);
                if ($t->is_empty_response()) {
                    $flagCell++;
                    echo "<tr>";
                    echo "<td>";
                    echo $picArr[$i];
                    $sheet->setCellValue('A'.$flagCell, $picArr[$i]);
                    echo "</td>";
                    echo "<td>";
                    $user_info = $tad->get_user_info(['pin' => $picArr[$i]])->to_array();
                    echo reset($user_info)['Name'];
                    $sheet->setCellValue('B'.$flagCell, reset($user_info)['Name']);
                    echo "</td>";
                    echo "<td>";
                    echo "N/A";
                    $sheet->setCellValue('C'.$flagCell, "N/A");
                    echo "</td>";
                    echo "<td>";
                    echo "N/A";
                    $sheet->setCellValue('D'.$flagCell, "N/A");
                    echo "</td>";
                    echo "</tr>";
                } else {
                    $t = $user_info->to_array();
                    if (!array_key_exists('PIN', $t['Row'])) {
                        $arr = reset($t);
                        for($j =0 ; $j<sizeof($arr);$j++){
                            $flagCell++;
                            echo "<tr>";
                            $arr = $t['Row'];
                            echo "<td>";
                            echo $arr[$j]["PIN"];
                            $sheet->setCellValue('A'.$flagCell, $arr[$j]["PIN"]);
                            echo "</td>";
                            echo "<td>";
                            $user_info = $tad->get_user_info(['pin' => $picArr[$i]])->to_array();
                            echo reset($user_info)['Name'];
                            $sheet->setCellValue('B'.$flagCell, reset($user_info)['Name']);
                            echo "</td>";
                            echo "<td>";
                            $date = explode(' ',$arr[$j]["DateTime"]);
                            echo $date[0];
                            $sheet->setCellValue('C'.$flagCell, $date[0]);
                            echo "<td>";
                            $time = $date[1];
                            echo $time;
                            $sheet->setCellValue('D'.$flagCell, $time);
                            echo "</td>";
                            echo "</td>";
                            echo "</tr>";
                        }

                    } else {
                        $flagCell++;
                        echo "<tr>";
                        $arr = $t['Row'];
                        echo "<td>";
                        echo $picArr[$i];
                        $sheet->setCellValue('A'.$flagCell, $picArr[$i]);
                        echo "</td>";
                        echo "<td>";
                        $user_info = $tad->get_user_info(['pin' => $picArr[$i]])->to_array();
                        echo reset($user_info)['Name'];
                        $sheet->setCellValue('B'.$flagCell, reset($user_info)['Name']);
                        echo "</td>";
                        echo "<td>";
                        echo "N/A";
                        $sheet->setCellValue('C'.$flagCell, "N/A");
                        echo "</td>";
                        echo "<td>";
                        echo "N/A";
                        $sheet->setCellValue('D'.$flagCell, "N/A");
                        echo "</td>";
                        echo "</tr>";
                    }
                }
            }
            echo "</table>";

            /*phpSpreadsheet*/




            $writer = new Xlsx($spreadsheet);
            $writer->save('report.xlsx');
            /*phpSpreadsheet*/

            echo "<br><a href='/uttara/report.xlsx'><input type='button' value='Download Excel File'/></a> ";
exit;
        }
    }

    public function deleteActivity($id)
    {
        $row = $this->Membership->Membership_Activity->get($id);
        if ($this->Membership->Membership_Activity->delete($row)) {
            $this->Flash->Success(__("Success! Activity Unassigned Successfully."));
            return $this->redirect($this->referer());
        }
    }

    public function isAuthorized($user)
    {
        $role_name = $user["role_name"];
        $curr_action = $this->request->action;
        $members_actions = ["membershipList"];
        $staff_acc_actions = ["membershipList", "add", "editMembership"];
        switch ($role_name) {
            CASE "member":
                if (in_array($curr_action, $members_actions)) {
                    return true;
                } else {
                    return false;
                }
                break;

            CASE "staff_member":
                if (in_array($curr_action, $staff_acc_actions)) {
                    return true;
                } else {
                    return false;
                }
                break;

            CASE "accountant":
                if (in_array($curr_action, $staff_acc_actions)) {
                    return true;
                } else {
                    return false;
                }
                break;
        }

        return parent::isAuthorized($user);
    }
}