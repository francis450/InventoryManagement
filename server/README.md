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

### Usage
1. To be determined....

## API DOCUMENTATION
Document the UniEvents APIs by describing the endpoints and providing examples of usage in `API.md` file in the server folder. Below are sample requests:
### GET Requests

- Endpoint: `/api/events`
- Description: Retrieves all events.
- Example:

    ```json
    GET http://localhost:8000/api/events
    ```

### POST Request

- Endpoint: `/api/event`
- Description: Creates a new event.
- Example:

    ```json
    POST http://localhost:5000/api/events
    Content-Type: application/json

    {
        "title": "Data Science Conference-Kabarak University",
        "description": "Event Description"
    }
    ```

### PUT Request

- Endpoint: `/api/event/{id}`
- Description: Updates an existing event.
- Example:

    ```json
    PUT http://localhost:5000/api/event/1
    Content-Type: application/json

    {
        "title": "Updated Title",
        "description": "Updated Description"
    }
    ```
## Contributing

We welcome contributions to UniEvent! If you find any bugs or have suggestions for new features, please open an issue on GitHub or submit a pull request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

👨‍💻 Happy Hosting with UniEvents! If you have any questions or need further assistance, feel free to reach out to us.