# Security

## Measures Implemented

- **Password hashing** — bcrypt via PHP `password_hash()`
- **SQL injection prevention** — all queries use PDO prepared statements
- **XSS prevention** — all user output passed through `htmlspecialchars()`
- **Access control** — role-based (student/admin) enforced on every protected page
- **Sensitive file protection** — `.env` and `.git` blocked at Nginx level
- **HTTPS** — enforced in production via Traefik and Let's Encrypt

## Reporting Issues

If you find a security issue, please email hi@elijahu.me rather than opening a public issue.
