<?php
class CatController {
    private $db; 
    private $Schema = "Cat"; 
    
    public function __construct($inDB) {
        $this->db = $inDB; 
    }
    //get all records
    public function getAll() {
        $result = $this->db->select($this->Schema, "*");
		return $result; 
    }
    //get one record by id
    public function getOne($reqBody) {
        $id = $reqBody["id"]; 
        $result = $this->db->get(
            $this->Schema, 
            "*", 
            ["id" => $id]
        ); 
		return $result; 
    }
    //create a new record
    public function create($reqBody){
        $cat = new Cat($reqBody);
        $this->db->insert(
            $this->Schema, 
            [
                "name"  => $cat->name, 
                "age"   => $cat->age, 
                "color" => $cat->color, 
            ]
        );
        $result = $this->getAll();
        return $result;
    }
    //edit a record 
    public function update($reqBody) {
        if ($reqBody) {
            $this->db->update(
                $this->Schema, 
                [
                    "name"  => $reqBody["name"], 
                    "age"   => $reqBody["age"], 
                    "color" => $reqBody["color"], 
                ], 
                [
                    "id" => $reqBody["id"]
                ]
            ); 
            $data = (object)["message" => "Updated success!"]; 
        }
        $result = $this->getAll();
        return $result;
    }
    //delete a record by id 
    public function delete($reqBody) {
        $id = $reqBody['id'];
        $this->db->delete(
            $this->Schema,
            ['id' => $id]
        );
        $data = (object)["message" => "Deleted success!"]; 
        $result = $this->getAll();
        return $result;
    }
}
?>