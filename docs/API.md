# API Reference

The README is the primary SDK documentation. It includes installation, configuration, response handling, data objects, examples, and the full resource method table.

See `src/Resources` for endpoint wrappers. All methods return `Softgeng\Paystack\Data\PaystackResponse`. Request payloads may be arrays or data objects implementing `DataObject`.

Data objects provide `fromArray()` and `toArray()` methods. `fromArray()` maps constructor-defined keys and ignores unrelated keys; `toArray()` returns the Paystack payload with null values removed.

This SDK tracks the current Paystack API Reference only: https://paystack.com/docs/api/.
