
# Authentication APIs with dj-rest-auth

This Django application provides authentication endpoints using dj-rest-auth. Follow the steps below to set up and use these APIs.


## Run Locally

Clone the project

```bash
  git clone https://github.com/francis450/UniEvents.git
```

Go to the project directory

```bash
  cd UniEvents
  cd server

```

Create and Activate a Virtual Environment

```bash
  python -m venv venv
  source venv/bin/activate
```

Install Dependencies:

```bash
  pip install -r requirements.txt
```

Run Migrations:

```bash
  python manage.py migrate
```

Start the Development Server:

```bash
  python manage.py runserver
```


## API Reference

#### Login

```http
  POST /dj-rest-auth/login/
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `username (or email)` | `string` | **Required**. username or email |
| `password`      | `string` | **Required**. Password |

##### Returns token key

#### Logout

```http
  POST /dj-rest-auth/logout/
```

#### Password Reset

```http
  POST /dj-rest-auth/password/reset/
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email`      | `string` | **Required**. Email |

#### Password Reset Confirmation

```http
  POST /dj-rest-auth/password/reset/confirm/
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `uid`      | `string` | **Required**. UID |
| `token`      | `string` | **Required**. Token |
| `new_password1`      | `string` | **Required**. New Password |
| `new_password2`      | `string` | **Required**. Confirm Password |

##### Note: uid and token are sent in an email after calling  ``` /dj-rest-auth/password/reset/. ```


#### User Registration

```http
  POST /dj-rest-auth/registration/
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `username`      | `string` | **Required**. Username |
| `email`      | `string` | **Required**. Email |
| `password`      | `string` | **Required**. Password |


## Documentation

For more details, refer to the full documentation: [Documentation](https://dj-rest-auth.readthedocs.io/en/latest/index.html)

