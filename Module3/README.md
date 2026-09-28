
# CMPS361 - Module 3

## 1. PostgreSQL Database Connection

I attempted to establish a connection between PHP and
PostgreSQL using PDO.

During testing, PHP recognized PDO, but the PostgreSQL
driver was not loading correctly.

I attempted to troubleshoot the driver configuration,
but I was unable to establish a successful database connection.

### PostgreSQL Driver Test

![PostgreSQL Driver Test](postgres-error.png)

## 2. Local API Connection

I created a local PHP API using api.php.

The API returns student information in JSON format.

I also created index.html, which uses JavaScript fetch()
to retrieve the information from the PHP API and display
the results in an HTML table.

### API JSON Results

![API Results](api-results.png)

### Successful API Connection

![API Connection Results](connection-results.png)

## 3. How to Run the Project

1. Open the Module3 folder in VS Code.
2. Open the terminal.
3. Run the following command:

   php -S localhost:8000

4. Open http://localhost:8000/api.php to view the JSON.
5. Open http://localhost:8000/index.html to view the API connection.

## Conclusion

The PostgreSQL connection was unsuccessful due to the
driver configuration issue.

However, the local PHP API connection was successfully
implemented and tested. The HTML webpage retrieves
the API data and displays it correctly.
