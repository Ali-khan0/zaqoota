# Repository instructions

Before planning or implementing any feature in this repository, read
`CODEBASE_CONTEXT.md` completely. Use its feature map and change matrix to
identify every affected route, controller, service/repository or CentralLogic,
model/migration, client API, view/asset, translation, integration, report, and
side effect.

Keep `CODEBASE_CONTEXT.md` current when a change introduces or relocates a
module, route surface, API version, integration, cross-cutting workflow, or
architectural convention.

For every mobile-facing API feature, create or update a dedicated specification
under `docs/api/` and add it to `docs/api/README.md`. Document authentication,
headers, request fields, response fields with JSON examples, errors, pagination,
mobile screen behavior, security constraints, and all relevant backend files.
The API document and implementation must be changed together.

Do not execute or include the suspected obfuscated root PHP files identified in
the "Known risks and cleanup targets" section.
