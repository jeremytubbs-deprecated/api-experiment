## API Experiment

Api for content, content_type, users and categroies.


### JWT
Setup auth token. Limit access to POST, PATCh, DELETE

### Accept Header
Utilizing Accept header for API versioning `/App/Http/Middleware/ApiAcceptHeaderV1`.
TODO add some sort of parsing on header to check version and response format.
I am still figuring this out and it is not truly required until actual versioning of the API.

### API Config
Setup config on models for allowed request parameters.

