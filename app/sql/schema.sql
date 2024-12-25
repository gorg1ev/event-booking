CREATE TABLE users
(
    id        INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(255) NOT NULL,
    email     VARCHAR(255) NOT NULL UNIQUE,
    pwd       VARCHAR(255) NOT NULL,
    avatar    VARCHAR(255) DEFAULT '/storage/user-avatar.jpg'
);

CREATE TABLE role
(
    id   INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name ENUM('ADMIN', 'USER') NOT NULL
)

CREATE TABLE user_roles
(
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE
)

CREATE TABLE events
(
    id           INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    thumbnail    VARCHAR(255) NOT NULL,
    title        VARCHAR(255) NOT NULL,
    description  TEXT         NOT NULL,
    price        FLOAT        NOT NULL,
    expired_date DATETIME     NOT NULL,
    location     VARCHAR(255) NOT NULL
);

CREATE TABLE ticket
(
    id          INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    event_id    INT NOT NULL,
    user_id     INT NOT NULL,
    amount      INT NOT NULL,
    date_bought DATETIME DEFAULT NOW(),
    FOREIGN KEY (event_id) REFERENCES events (id),
    FOREIGN KEY (user_id) REFERENCES users (id),

);