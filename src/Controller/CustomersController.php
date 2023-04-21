<?php

namespace App\Controller;
use App\Model\Table\CustomersTable;
use Cake\Datasource\ConnectionManager;

class CustomersController extends AppController
{

    public function index()
    {
        $csrfToken = $this->request->getData('_csrfToken');

        if ($this->request->is(['post'])) {
            $data = explode(",", $this->request->getData("customer"));

            if ($this->update($data)) {
                $response = ["response" => "OK", 'message' => 'The customer has been updated'];
            } else {
                $response = ["response" => "error", 'message' => 'Error message'];
            }
            echo json_encode($response);
            exit();
        }

        $customers = $this->Customers->find('all', [
            'order' => ['Customers.position' => 'ASC']
        ]);

        $this->set(compact('customers'));
    }

    public function update($data)
    {


        $position = 1;

        $connection = ConnectionManager::get('default');
        $connection->begin();
        try {

            foreach ($data as $id) {
                $customer = $this->Customers->get($id);
                $customer->position = $position;
                $this->Customers->save($customer, ['atomic' => false]);
                $position++;
            }

            $connection->commit();
            $this->Flash->success(__('The customer position has been updated.'));
            return true;
        } catch (Exception $e) {
            $connection->rollback();
            $this->Flash->error(__('An error occurred while updating the customer position.'));
            return false;
        }
    }

}
