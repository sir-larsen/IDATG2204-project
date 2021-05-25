# Project is not finished. Not worth reviewing yet

# Api tests

### Customer endpoints:
| URI | Description of functionality | Purpose of test | Responsible | Time of implementation |
|-----|-------------|---------------|------------------------------|------------------------------------|
|/customer/{:customer_id}/orders?since={:dd-mm-yyyy} | Retrieve a list of orders they have made (with an optional since filter) |Test that all orders made by the right customer is listed and that the correct ones are showcased using the filter.  |  Sander Fuhr| While developing the specified endpoint |
|/customer/{:customer_id}/{:order_number} | Retrieve information about a specific order and its state | Test that the right order matched with the right customer displays the correct information about an order. | Alexander Eckhoff Larsen | While developing the specified endpoint |
|/customer/{:customer_id}/place_order  | Allows user to place an order by sending a post request using e.g Postman.| Test that a user is able to place an order by sending a body consisting of order information.| Markus Zakarias Strømseth| While developing the specified endpoint|


