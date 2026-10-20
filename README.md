# Product Portfolio Management System (PPMS)

**Individual university project — Web Technology**

A Korean-food-themed product portfolio and ordering web application developed using PHP, MySQL/MariaDB, HTML, CSS, and JavaScript. It features customer-facing pages and a separate administrative interface.

## Features

**Customer interface:** Browse Korean food products and categories, search and view product details, register and log in, use a shopping cart, check out, view order history, read blog posts, and submit reviews.

**Administrator interface:** Manage products and categories, blog entries, reservations/orders, customer reviews, and registered users.

## Technology

- PHP (server-side application)
- MySQL / MariaDB with MySQLi
- HTML, CSS, and JavaScript
- XAMPP for local development

## Run locally

1. Install XAMPP with Apache, PHP, MySQL/MariaDB, and phpMyAdmin.
2. Copy the `ppms/` application directory into the XAMPP `htdocs/` directory.
3. Start Apache and MySQL in XAMPP.
4. In phpMyAdmin, create an **empty** database named `ppms` and import the included **`ppms.sql`** file once.
5. Check `ppms/config/config.php` for the local database username, password, and URLs. Defaults use MySQL `root` with an empty password and `http://localhost/ppms/`; adjust for your environment.
6. Open `http://localhost/ppms/` to view the site, or `http://localhost/ppms/admin/` for the administrator interface.
7. Sign in using the demo accounts below, or register a new customer (new accounts are assigned `userRoles = 2` by default).

## Demo login (local testing only)

The included `ppms.sql` already contains the accounts below, stored with bcrypt password hashes. **No extra database import is needed.** These credentials came from the supplied project archive and were checked against the SQL hashes using PHP `password_verify()`.

| Role | Email | Password | `userRoles` |
| --- | --- | --- | --- |
| Customer | `user1@email.com` | `user1` | `2` |
| Administrator | `admin1@email.com` | `admin1` | `1` |

Every newly registered account has role `2` by default. If you want to promote a separate local testing account to admin, first register it and then update its role in phpMyAdmin:

```sql
UPDATE user SET userRoles = 1 WHERE userEmail = 'new-admin@example.com';
```

**Security warning:** The above are *public disposable demo credentials*. Do not reuse them with other services or use this database unchanged on an internet-facing deployment.

## Screenshots

See `screenshots/user/` and `screenshots/admin/` for the customer and administrator workflows. The archive includes screenshots of product browsing, cart, checkout, orders, reviews, dashboard, product management, and more.

## Repository and deployment notes

- This is a university portfolio showcase of the original PHP/MySQL application. It has not undergone a full security audit or production hardening. Review authorization, SQL parameterization, form security, escaping, and order validation before any public hosting.
- Standard static Vercel hosting **will not run PHP + MySQL**. A Vercel portfolio can instead show the project screenshots and link to this source repository.
- Six machine-specific absolute XAMPP paths were converted to portable paths. Other than those setup portability changes, the supplied application and SQL were preserved.
- The separate `crediantials.txt` file was excluded to avoid redundant standalone credential files; the demo details are documented above.

## Project ownership

Individual Web Technology university assignment. Add the repository owner's preferred name and attribution when publishing.
