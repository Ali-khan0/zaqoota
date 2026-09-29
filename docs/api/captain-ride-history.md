# Captain Ride history

`GET /api/v1/delivery-man/rides` returns only completed or cancelled Rides
assigned to the authenticated Captain. It supports `page`, `limit`, `status`
(`completed` or `cancelled`), `from`, and `to` (`Y-m-d`).

Rows use the same authoritative Captain trip representation as
`GET /api/v1/delivery-man/rides/{ride_id}` and include lifecycle timestamps,
pickup/destination, accepted fare, waiting/cancellation amounts, Captain
earning, payment/settlement state, receipt, vehicle/customer summaries, and
cancellation receivable state. `My Offers` remains a separate offer log.

History access does not depend on customer booking enablement or the Captain's
current Delivery/Ride work mode. Both list and details are ownership-scoped by
`delivery_man_id`.
