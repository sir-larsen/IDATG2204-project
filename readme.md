# Database project 
## How to install
For the installation and deployment of this project you will need to use XAMPP.
Clone the repo and move the files to C:\xampp\htdocs (for windows users). Make sure that the .htaccess files is in the root
(htdocs/). Must also import the project.sql into phpmyadmin. Rename the project from 'idatg2204-project' to 'api'. Or modify the .htaccess file in regards to the name you want the
project to use.

## Endpoints
The four main endpoints of this API are:
```
http://localhost/api/company/
http://localhost/api/customer/
http://localhost/api/transporter/
http://localhost/api/public/
```
Each one of them with their own functionality. Every endpoint, aside from /public, uses hashes to authorise users.
These can be found here, and also in the project.sql file under the `auth_token` table. The hashes will need to be passed as 
cookies when making requests, we suggest using Postman for this. As the service works now, there are five different hashes 
required for the different endpoints, the /customer/ and /transport/ urls use a single hash each, while the company endpoint
requires separate hashes for the different user-type subdirectories.

### Hashes for different endpoints:
```
//customer_rep
7f38212946ddbd7aadba90192887c5538328bb77bf3756504a1e538226fa8f51    
                                                                   
//storekeeper
4b36a056eebfab7e4bbb26a278309812f55623b9675d4b4e9345f3fbf89e71d3

//production_planner
9d34402491a7e00f0ed216ed2f6ac63b2848ce41ad17a65bde2fffd47f7445c2

//customer
544c4686e64cdcdaba07ec71b4940122b0e9cc844d803d6cbc7282e139b08960

//transport
d8af1f1d29016d1c4b13954d6a605a62b511c88f8f35539a3efd97547e925132

Customer_rep, storekeeper and production_planner hashes will all take you through the
first authorization check to the /company/ endpoint, however you will need the correct employee
type hash for further endpoints down /company paths.
```

## The company endpoint
### METHOD GET
#### http://localhost/api/company/customer_rep/orders?state={:order_state}
#### http://localhost/api/company/customer_rep/orders?state=new,open,skis-avaliable,ready-to-be-shipped
```
Endpoint for customer_rep to get orders based on order states. States are passed in query string. 
http://localhost/api/company/customer_rep/orders?state={:order_state}                                    

example usage:
http://localhost/api/company/customer_rep/orders?state=new,open,skis-avaliable,ready-to-be-shipped

Response:
[
    {
        "order_nr": 1,
        "state_id": "new",
        "parent_id": 0,
        "total_price": 0,
        "customer_id": 2,
        "customer_rep": 1,
        "date_placed": "2021-03-15"
    },
    {
        "order_nr": 2,
        "state_id": "new",
        "parent_id": 0,
        "total_price": 0,
        "customer_id": 1,
        "customer_rep": 1,
        "date_placed": "2021-05-10"
    }
]       
```
### METHOD POST
#### http://localhost/api/company/customer_rep/orders/{:employee_nr}/{:order_nr}
 With JSON body: { "new_state": "order_state" }
#### http://localhost/api/company/customer_rep/orders/1/2
 With JSON body: { "new_state": "skis avaliable" }
```
Endpoint for customer_reps to change the order state.
http://localhost/api/company/customer_rep/orders/{:employee_nr}/{:order_nr} POST { "new_state": {:order_state} }

Example usage:
http://localhost/api/company/customer_rep/orders/1/2 { "new_state": "open" }

Example response:
{
    "status": 200,
    "result": {
        "order_nr": 2,
        "customer_rep": 1,
        "state": "skis avaliable"
    }
}
```

## The public endpoint
### METHOD GET
#### http://localhost/api/public

```
Endpoint for everyone to display all the different skis that the company offers.  
http://localhost/api/public                                

example usage:
http://localhost/api/public     

Response:
[
    {
        "product_no": 1,
        "url": null,
        "msrpp": "1700",
        "in_production": "yes",
        "model": "Endurance",
        "grip": "wax",
        "type": "skate",
        "min_weight": "20",
        "max_weight": "30",
        "size": "135",
        "temp": "cold"
    },
    {
        "product_no": 2,
        "url": null,
        "msrpp": "1700",
        "in_production": "yes",
        "model": "Race Pro",
        "grip": "wax",
        "type": "skate",
        "min_weight": "30",
        "max_weight": "40",
        "size": "140",
        "temp": "cold"
    },
    {
        "product_no": 3,
        "url": null,
        "msrpp": "1700",
        "in_production": "yes",
        "model": "Active Pro",
        "grip": "IntelliGrip",
        "type": "skate",
        "min_weight": "40",
        "max_weight": "50",
        "size": "150",
        "temp": "cold"
    }
]       
```

### METHOD GET
#### http://localhost/api/public/model/{:model_name}

```
Endpoint for everyone to filter all the different skis based on model.  
http://localhost/api/public/model/{:model_name}                                

example usage:
http://localhost/api/public/model/Endurance     

Response:
[
    {
        "product_no": 1,
        "url": null,
        "msrpp": "1700",
        "in_production": "yes",
        "model": "Endurance",
        "grip": "wax",
        "type": "skate",
        "min_weight": "20",
        "max_weight": "30",
        "size": "135",
        "temp": "cold"
    }
]       
```

### METHOD GET
#### http://localhost/api/public/grip/{:grip_name}

```
Endpoint for everyone to filter all the different skis based on grip type.  
http://localhost/api/public/grip/{:grip_name}                                

example usage:
http://localhost/api/public/grip/wax     

Response:
[
    {
        "product_no": 1,
        "url": null,
        "msrpp": "1700",
        "in_production": "yes",
        "model": "Endurance",
        "grip": "wax",
        "type": "skate",
        "min_weight": "20",
        "max_weight": "30",
        "size": "135",
        "temp": "cold"
    },
    {
        "product_no": 2,
        "url": null,
        "msrpp": "1700",
        "in_production": "yes",
        "model": "Race Pro",
        "grip": "wax",
        "type": "skate",
        "min_weight": "30",
        "max_weight": "40",
        "size": "140",
        "temp": "cold"
    }
]       
```
## The transporter endpoint
### METHOD GET
#### http://localhost/api/transporter

```
Endpoint for transporter to display all orders ready for pickup.
 http://localhost/api/transporter                                    

example usage:
 http://localhost/api/transporter

Response:
[
    {
        "order_nr": 1,
        "state": "ready to be shipped",
        "parent_id": "Not a sub-order",
        "total_price": "No price information received",
        "customer_id": "2",
        "customer_rep": "Maximiliano Zakarias",
        "date_placed": "2021-03-15"
    }
]
```
### METHOD GET
#### http://localhost/api/transporter/pickedup/{:shipment_nr}

```
Endpoint for transporter to update shipments ready for shipping to picked up.
Updates the database with new state_id.
http://localhost/api/transporter/pickedup/{:shipment_nr}                                   

example usage:
 http://localhost/api/transporter/pickedup/1

Response:
[
    shipment nr: 1 is set ready for shipping: {
    "nr": 1,
    "pickup_date": "2021-04-05",
    "company_name": "postnord",
    "driver_id": "1",
    "state_id": "1",
    "address_id": "1"
}
]
```

## Customer endpoint

### METHOD GET
```
Endpoint for retrieving a list of all customers.
http://localhost/api/customer

Example response:
[
    {
        "id": 1,
        "start_date": "2020-01-01",
        "end_date": "2021-01-01",
        "customer_rep": "1"
    },
    {
        "id": 2,
        "start_date": "2020-02-02",
        "end_date": "2021-02-02",
        "customer_rep": "1"
    },
    {
        "id": 3,
        "start_date": "2019-01-01",
        "end_date": "2020-01-01",
        "customer_rep": "1"
    },
    {
        "id": 4,
        "start_date": "2017-01-01",
        "end_date": "2021-01-01",
        "customer_rep": "1"
    },
    {
        "id": 5,
        "start_date": "2018-04-27",
        "end_date": "2021-02-14",
        "customer_rep": "1"
    }
]
```

### METHOD GET
```
Endpoint for retrieving a specific order based on its unique id.
http://localhost/api/customer/{:customer_id}/{order_nr}

Example response:
[
    {
        "order_nr": 2,
        "order_state": "new",
        "customer_id": "1",
        "customer_rep": "Maximiliano Zakarias",
        "total_price": null,
        "date_placed": "2021-05-10"
    }
]
```

### METHOD GET
```
Endpoint for retrieving all orders placed since a specific date.
http://localhost/api/customer/{:customer_id}/orders?since={:yyyy-mm-dd}

Example response:
[
    {
        "order_nr": 2,
        "order_state": "new",
        "customer_id": "1",
        "customer_rep": "Maximiliano Zakarias",
        "total_price": null,
        "date_placed": "2021-05-10"
    },
    {
        "order_nr": 3,
        "order_state": "new",
        "customer_id": "3",
        "customer_rep": "Maximiliano Zakarias",
        "total_price": null,
        "date_placed": "2021-05-24"
    },
    {
        "order_nr": 4,
        "order_state": "new",
        "customer_id": "4",
        "customer_rep": "Maximiliano Zakarias",
        "total_price": null,
        "date_placed": "2021-04-11"
    },
    {
        "order_nr": 5,
        "order_state": "new",
        "customer_id": "4",
        "customer_rep": "Maximiliano Zakarias",
        "total_price": null,
        "date_placed": "2021-04-28"
    }
]
```

### METHOD POST
```
Endpoint for creating a new order.
http://localhost/api/customer/{:customer_id}/placeorder

Example request:
{
    "state_id": 1
    "parent_id": 1
    "customer_id": 3
    "customer_rep": 2
    "model": 2
    "quantity": 1
}

Example response:
{
    "id": 8,
    "state_id": "1",
    "parent_id": "1",
    "total_price": "1700",
    "customer_id": "3",
    "customer_rep": "2"
}
```

### METHOD DELETE
```
Endpoint for canceling an order based on its unique id.
http://localhost/api/customer/cancel_order/{order_nr}

Example response:
"Deleted order with number: 8"
```

### Api test scheme

### Customer endpoints:
| URI | Description of functionality | Purpose of test | Responsible | Time of implementation |
|-----|-------------|---------------|------------------------------|------------------------------------|
|/customer/{:customer_id}/orders?since={:dd-mm-yyyy} | Retrieve a list of orders they have made (with an optional since filter) |Test that all orders made by the right customer is listed and that the correct ones are showcased using the filter.  |  Sander Fuhr| While developing the specified endpoint |
|/customer/{:customer_id}/{:order_number} | Retrieve information about a specific order and its state | Test that the right order matched with the right customer displays the correct information about an order. | Alexander Eckhoff Larsen | While developing the specified endpoint |
|/customer/{:customer_id}/place_order  | Allows user to place an order by sending a post request using e.g Postman.| Test that a user is able to place an order by sending a body consisting of order information.| Markus Zakarias Strømseth| While developing the specified endpoint|
|/customer/{:customer_id}/cancel_order/{:order_number} | Allows user to cancel an order based on the order number | Test that only the authorized user is able to cancel the right order. It should then update its state. | Sander Fuhr | While developing the specified endpoint|
|/customer/{:customer_id}/split/{:order_number} |The unfilled items in the order is moved to a new order (set in the open state), and the existing order is changed from the skis available to ready for shipment states. | Test that the order is being split appropriately and that the right states are set. | Alexander Eckhoff Larsen | While developing the specified endpoint |
|/customer/{:customer_id}/retrieve_plan | Retrieve a four-production plan summary showing the total number of skies of each type being planned for the period | Test that the correct plan with correct information is being showcased. | Markus Zakarias Strømseth | While developing the specified endpoint|

### Company endpoints:

| URI | Description of functionality | Purpose of test | Responsible | Time of implementation |
|-----|-------------|---------------|------------------------------|------------------------------------|
|/company/customer_rep/orders?state={:state} | Retrieve a list of orders based state. Without the flag all orders will be showcased. |Test that the appropriate orders will be displayed. This includes that the orders are in the specified state and that they truly belong to the specified customer rep.  |  Sander Fuhr| While developing the specified endpoint |
|POST request { "new_state": {:new_state} }
/company/customer_rep/orders/{:employee_nr}/{:order_number} | Changes a state of an order from the current one to the new specified in the url. | Test that the order gets assigned its new state and that only legal states goes through | Alexander Eckhoff Larsen | While developing the specified endpoint|
|/company/customer-rep/{:employee_nr}/shipments | Create a shipment request when an order has been filled. Post request through postman. | Test that shipments gets created and that only orders ready for shipping can be filled in.| Markus Zakarias Strømseth |  While developing the specified endpoint |
|/company/storekeeper/{:employee_nr}/skis | Adding information about newly produced skis as they have passed quality control through Post request. | Test that skis are successfully placed in the database with the correct information. | Sander Fuhr | While developing the specified endpoint |
|/company/storekeeper/{:employee_nr}/available_skis | Retrieving orders in the "available skis" state. | Test that the appropriate orders are being retrieved with the right states. | Alexander Eckhoff Larsen | While developing the sepcified endpoint |
|/company/storekeeper/{:employee_nr}/{:order_number}/ready | Changing the state of an order from skis available to ready to be shipped when the order has been filled | Test that the order's state is successfully updated and that only orders with "skis available" can be set to ready to be shipped. | Markus Zakarias Strømseth | While developing the specified endpoint |
|/company/production_planner/{:employee_nr}/plan | Uploading the production plan for a given four-week period using a POST request. | Test that the plan is successfully uploaded and that the information is formatted right. | Alexander Eckhoff Larsen | While developing the specified endpoint |


### Transporter endpoints:

| URI | Description of functionality | Purpose of test | Responsible | Time of implementation |
|-----|-------------|---------------|------------------------------|------------------------------------|
|/transporter/orders | Retrieve information about orders ready for shipment |Test that the appropriate orders are being retrieved with the right states.  |  Sander Fuhr | While developing the specified endpoint |
|/transporter/shipment/{:shipment_number} | Change the state of the shipment when it has been picked up | Test that the correct shipment's state is updated with the appropriate state. | Alexander Eckhoff Larsen |  While developing the specified endpoint |


### Public endpoint:

| URI | Description of functionality | Purpose of test | Responsible | Time of implementation |
|-----|-------------|---------------|------------------------------|------------------------------------|
|/?model={:model_name} | Through this interface, any Internet user should be able to find information about the various types of skis. The user may optionally specify a filter based on model names. |Test that all skis are displayed with the correct information when using the standard public interface. When using the filter, information about a single model should be displayed.  |  Markus Zakarias Strømseth | While developing the specified endpoint |
