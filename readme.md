# Project is not finished. Not worth reviewing yet

# Api tests

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
|/company/customer_rep/{:employee_nr}/orders?state={:state} | Retrieve a list of orders based state. Without the flag all orders will be showcased |Test that the appropriate orders will be displayed. This includes that the orders are in the specified state and that they truly belong to the specified customer rep.  |  Sander Fuhr| While developing the specified endpoint |
|/company/customer_rep/{:employee_nr}/{:order_number}/{:new_state} | Changes a state of an order from the current one to the new specified in the url | Test that the order gets assigned its new state and that only legal states goes through | Alexander Eckhoff Larsen | While developing the specified endpoint|
|/company/customer-rep/{:employee_nr}/shipments | Create a shipment request when an order has been filled. Post request through postman | Test that shipments gets created and that only orders ready for shipping can be filled in.| Markus Zakarias Strømseth |  While developing the specified endpoint |
|/company/storekeeper/{:employee_nr}/skis | Adding information about newly produced skis as they have passed quality control through Post request. | Test that skis are successfully placed in the database with the correct information. | Sander Fuhr | While developing the specified endpoint |
