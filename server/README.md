# UniEvents Server Side

## Expected Features
- **User Authentication**: User registration, login, logout, and password reset.

- **Event Management**: creating, editing, and deleting events, along with visibility settings.

- **Event Registration**: events registration, registration status tracking, and managing event capacities.

- **Email Notifications**: Implement automated email notifications for event-related updates and reminders.

- **Feedback and Rating System**: For users to provide feedback and ratings on events.

- **Admin Panel**: Panel for managing users, events, and system settings.

- **Reporting and Analytics**: Implement event attendance tracking and user engagement analytics.

- **API Development**: Build RESTful APIs for frontend integration and external system interaction.

## Getting Started

### Prerequsites

- 
-

### Installation
1. **Clone the repository** from the main branch.
    ```bash
    git clone https://github.com/francis450/UniEvents.git
    ```
2. Navigate to the project directory:

    ```bash
    cd UniEvents/server
    ```
3. To be continued....

# Dj-Rest-Auth
[![<iMerica>](https://circleci.com/gh/iMerica/dj-rest-auth.svg?style=svg)](https://app.circleci.com/pipelines/github/iMerica/dj-rest-auth)


Drop-in API endpoints for handling authentication securely in Django Rest Framework. Works especially well 
with SPAs (e.g., React, Vue, Angular), and Mobile applications. 

## Requirements
- Django 2, 3, or 4 (See Unit Test Coverage in CI)
- Python 3

## Quick Setup

Install package

    pip install dj-rest-auth
    
Add `dj_rest_auth` app to INSTALLED_APPS in your django settings.py:

```python
INSTALLED_APPS = (
    ...,
    'rest_framework',
    'rest_framework.authtoken',
    ...,
    'dj_rest_auth'
)
```
    
Add URL patterns

```python
urlpatterns = [
    path('dj-rest-auth/', include('dj_rest_auth.urls')),
]
```
    

(Optional) Use Http-Only cookies

```python
REST_AUTH = {
    'USE_JWT': True,
    'JWT_AUTH_COOKIE': 'jwt-auth',
}
```

### Testing

Install required modules with `pip install -r  dj_rest_auth/tests/requirements.pip`

To run the tests within a virtualenv, run `python runtests.py` from the repository directory.
The easiest way to run test coverage is with [`coverage`](https://pypi.org/project/coverage/),
which runs the tests against all supported Django installs. To run the test coverage 
within a virtualenv, run `coverage run ./runtests.py` from the repository directory then run `coverage report`.

#### Tox

Testing may also be done using [`tox`](https://pypi.org/project/tox/), which
will run the tests against all supported combinations of Python and Django.

Install tox, either globally or within a virtualenv, and then simply run `tox`
from the repository directory. As there are many combinations, you may run them
in [`parallel`](https://tox.readthedocs.io/en/latest/config.html#cmdoption-tox-p)
using `tox --parallel`.

The `tox.ini` includes an environment for testing code [`coverage`](https://pypi.org/project/coverage/)
and you can run it and view this report with `tox -e coverage`.

Linting may also be performed via [`flake8`](https://pypi.org/project/flake8/)
by running `tox -e flake8`.

### Documentation

View the full documentation here: https://dj-rest-auth.readthedocs.io/en/latest/index.html


### Acknowledgements

This project began as a fork of `django-rest-auth`. Big thanks to everyone who contributed to that repo!
