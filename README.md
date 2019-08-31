REST API
-------------------

### Authentification

To authenticate with the API, either a staff user or an API user is needed.

##### Authentification via API user (recommended):

Send an http request to ```api/auth/key``` with ```key``` (auth key) and ```password``` as POST parameters to get your access token:

```
curl -i -H "Accept:application/json" "<HOST>/api/auth/key" -d "key=<auth key>&password=<password>"
```

##### Authentification via staff user:

Send an http request to ```api/auth/sid``` with ```sid``` and ```password``` as POST parameters to get your access token:

```
curl -i -H "Accept:application/json" "<HOST>/api/auth/sid" -d "sid=<sid>&password=<password>"
```

To make an authenticated call, the retrieved access_token has to be send along every request

This can be done by header (recommended):

```
curl <...> --header "access-token: <access token>"
```

or as a GET parameter:

```
curl <...> "<url>&access-token=m5j3jSydPVHyj_OaGvnm5mqqWaJhVJMU"
```

### API Calls

#### Staff

#### api/staff/view

GET-Parameters:

- **sid**: Staff SID

**Response**: Detailed information about the requested staff entry  



#### api/staff/access-list

GET-Parameters:

- **sid**: Staff SID

**Response**: List of all access keys the user has access rights to  



#### api/staff/has-access

GET-Parameters:

- **sid**: Staff SID
- **accessKey**: Key of access right to read, first part or whole

**Response**: Boolean if the user is permitted a specific action or not


#### api/section/keys

No parameters
api/base-category/keys is deprecated and will be removed soon!

**Response**: Array of all base categories. 
Structure BaseCategory::name => BaseCategory::key

