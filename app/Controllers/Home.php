<?php

namespace App\Controllers;

use App\Models\CommonModel;
use CodeIgniter\API\ResponseTrait;



class Home extends BaseController
{
    use ResponseTrait;
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
}