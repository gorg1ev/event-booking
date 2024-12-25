# Event Booking Project

## Overview

The Event Booking Project is a web application developed to practice PHP with Database. Its offers functionality for
user to register, login, manage the profiles, and book tickets for events. Admin users have additional privileges to
manage events. The app includes role-based access control to differentiate between regular users and administrators.

---

## Features

### User Management

- **Login and Registration:** Users can create an account and log in to access the system.

- **Profile Updates:** Users can update their profile information, including:
    - Changing profile picture
    - Updating their name
    - Changing their password

### Roles and Permissions

- Admin Role:
    - Create events, including:
        - Uploading a thumbnail
        - Adding a title, description, date, and price for each event

- User Role:
    - Browse available events
    - Purchase tickets for events

### Event Management

- Admins can create detailed events with:
    - **Thumbnail:** Upload an image to represent the event.
    - **Title:** Specify the event's name.
    - **Description:** Provide detailed information about the event.
    - **Date:** Set the event's schedule.
    - **Price:** Assign a ticket price for the event.

### Ticket Management

- **Purchase Tickets:** Users can buy tickets for events, but only if logged in.
- **View Purchased Tickets:** A dedicated route allows users to see all tickets they have purchased.

---

## Installation and Setup

### 1. Clone the Repository

```bash
git clone <repository-url>
cd event-booking
```

### 2. Set Up the Database

1. Create a database named `events` in your MySQL server:
   ```sql
   CREATE DATABASE events;
   ```
2. Import the SQL schema and initial data from the `app/sql` directory into the `events` database:
   ```bash
   mysql -u <username> -p events < app/sql/schema.sql
   ```

### 3. Configure the Environment Variables

1. Create a `.env` file in the project root directory with the following keys:
   ```env
   DB_DRIVER=mysql
   DB_DATABASE=events
   DB_HOST=db
   DB_USERNAME=<your-username>
   DB_PASSWORD=<your-password>
   ```
   Replace `<your-username>` and `<your-password>` with your actual database credentials.

### 4. Run the Application with Docker

1. Build and start the Docker containers:
   ```bash
   docker-compose up --build
   ```

### 5. Access the Application

- Open your browser and go to: [http://localhost](http://localhost)

---

## Feature Improvements

### Admin Features

- Admin can edit events.
- Admin can delete events.

### User Features

- Users can cancel tickets within 5 minutes of purchase.
- Tickets have a limited quantity and will not be available once sold out.

### Event Management

- Schedule events by setting specific dates.
- Scheduled events automatically expire after the event date.

### Ticket Enhancements

- Add a user interface for tickets, including a QR code for validation.
