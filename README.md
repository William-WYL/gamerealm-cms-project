## Database Setup

This project includes a `database.sql` file which contains the schema and sample data for the database.

### How to use:

1. Create a new MySQL database, for example:

    ```sql
    CREATE DATABASE gamerealm;
    ```

2. Import the `database.sql` file into your MySQL database:

    ```bash
    mysql -u your_username -p gamerealm < database.sql
    ```

    Or using a GUI tool like phpMyAdmin or MySQL Workbench.

3. Update your database connection settings in the project config file (if necessary).
