<?php

namespace App\Controllers;

use App\Models\CommonModel;
use CodeIgniter\API\ResponseTrait;

date_default_timezone_set("Asia/Kolkata");


class Home extends BaseController
{
    use ResponseTrait; // CodeIgniter's ResponseTrait provides helper methods to 
    //simplify sending API responses, such as JSON responses.
    //It provides methods like respond(), respondCreated(), respondDeleted(), and respondError(),
    // making it easy to send standard HTTP responses from your controller.
    private $model;
    function __construct()
    {
        $this->model = new CommonModel();
    }
    public function index($id = null)
    {


        if ($id == null) {
            $fetchRecord = $this->model->selectRecord("apis");
            $result = ["status" => 201, "data" => $fetchRecord];
        } else {
            $fetchRecord = $this->model->selectRecord("apis", ["id" => $id]);
            if (!empty($fetchRecord)) {
                $result = ["status" => 201, "data" => $fetchRecord];
            } else {
                $result = ["status" => 404, "data" => "No record found"];
            }
        }


        return $this->respond($result);
    }
    public function delete($id)
    {
        $selectdata = $this->model->selectRow("apis", ["id" => $id]);
        if (!is_numeric($id) || $id <= 0) {
            return $this->respond(["status" => 400, "data" => "Invalid ID"]);
        }

        if (!empty($selectdata)) {
            $delete = $this->model->deleteValue("apis", ["id" => $id]);
            if ($delete) {
                $result = ["status" => 201, "data" => "Deleted Successfully"];
            } else {
                $result = ["status" => 404, "data" => "Some error occured"];
            }
        } else {
            $result = ["status" => 404, "data" => "No record found"];
        }

        return $this->respond($result);
    }
    public function status($id, $status)
    {
        $selectdata = $this->model->selectRow("apis", ["id" => $id]);
        if (!is_numeric($id) || $id <= 0) {
            return $this->respond(["status" => 400, "data" => "Invalid ID"]);
        }

        if (!empty($selectdata)) {

            if ($status == "Active") {
                $action = "Inactive";
            } else {
                $action = "Active";
            }
            $data = ["status" => $action];
            $update = $this->model->updateValue("apis", ["id" => $id], $data);
            if ($update) {
                $result = ["status" => 201, "data" => "Updated Successfully"];
            } else {
                $result = ["status" => 404, "data" => "Some error occured"];
            }
        } else {
            $result = ["status" => 404, "data" => "No record found"];
        }

        return $this->respond($result);
    }
    public function create($id = null)
    {

        if ($this->request->getMethod() == "POST") {
            $name = $this->request->getVar("name");
            $email = $this->request->getVar("email");
            $title = $this->request->getVar("title");
            $date = date('Y-m-d H:i:s');


            if ($id == null) {
                $data = [
                    "name" => $name,
                    "email" => $email,
                    "title" => $title,
                    "creation_date" => $date
                ];
                $insert = $this->model->insertValue("apis", $data);
                if ($insert) {
                    $result = ["status" => 201, "data" => "Data insert successfully."];
                } else {
                    $result = ["status" => 404, "data" => "Some Error Occurred."];
                }
            } else {
                $selectdata = $this->model->selectRow("apis", ["id" => $id]);
                if (!is_numeric($id) || $id <= 0) {
                    return $this->respond(["status" => 400, "data" => "Invalid ID"]);
                }

                if (!empty($selectdata)) {
                    $data = [
                        "name" => $name,
                        "email" => $email,
                        "title" => $title,
                        "updation_date" => $date

                    ];
                    $update = $this->model->updateValue("apis", ["id" => $id], $data);
                    if ($update) {
                        $result = ["status" => 201, "data" => "Data updated successfully."];
                    } else {
                        $result = ["status" => 404, "data" => "Some Error Occurred."];
                    }
                } else {
                    $result = ["status" => 404, "data" => "No record found."];
                }
            }
        } else {
            $result = ["status" => 404, "data" => "No post method found."];
        }
        return $this->respond($result);
    }
}
