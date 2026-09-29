# Ride chat API

Ride chat is separate from commerce conversations. Only the owning customer and
assigned Captain can access it. Reading is retained for assigned terminal Rides;
sending is limited to `rider_selected`, `captain_arriving`, `arrived`, and
`in_progress`.

Customer base: `/api/v1/ride-hailing/customer/rides/{ride_id}`

Captain base: `/api/v1/delivery-man/rides/{ride_id}`

| Method | Suffix | Purpose |
|---|---|---|
| GET | `/messages?page=1&limit=30` | Newest-first paginated messages plus `can_send`, `read_only`, and `ride_status` |
| POST | `/messages` | Send `{client_id, message}`; retrying the same client ID returns the original row |
| PUT | `/messages/seen` | Mark only the other participant's unread messages seen |
| PUT | `/chat-presence` | Set `{active: true\|false}`; active heartbeats expire after 75 seconds |

Messages publish `ride.message.created` and `ride.message.seen` on the existing
private `ride.trip.{ride_id}` channel. The recipient always receives an in-app
notification. Firebase push is skipped only while an unexpired presence proves
that recipient is viewing the same Ride chat.

Completed and cancelled assigned Rides remain readable by their original two
participants. Their message response sets `can_send: false` and
`read_only: true`; send requests remain rejected. A terminal Ride can never
publish active chat presence, even if an old client submits `active: true`.

The message response also contains a privacy-scoped `contact` object for the
authorized opposite participant:

```json
{
  "contact": {
    "name": "Captain or customer name",
    "phone": "+923001234567",
    "sender_name": "Authenticated participant name",
    "ride_number": "ZQR-0000042",
    "destination_name": "Destination address"
  }
}
```

It is returned only after the existing customer-owner or assigned-Captain Ride
scope succeeds. It contains no unrelated participant or account fields.
