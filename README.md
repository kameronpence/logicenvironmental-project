# Logic Environmental Website

Environmental consulting company website built with Laravel 11.

## Server Configuration

- **Web Server:** Apache2
- **PHP Version:** 8.3
- **Database:** MySQL/MariaDB
- **Framework:** Laravel 11

### Key Configuration Files

| File | Purpose |
|------|---------|
| `/etc/apache2/sites-enabled/000-default.conf` | Apache virtual host |
| `/etc/php/8.3/apache2/php.ini` | PHP configuration |
| `.env` | Environment variables |

### File Upload Limits

| Setting | Value | Location |
|---------|-------|----------|
| `upload_max_filesize` | 100M | `/etc/php/8.3/apache2/php.ini` |
| `post_max_size` | 500M | `/etc/php/8.3/apache2/php.ini` |
| Laravel validation | 100MB/file, 5 files max | `ProposalController.php` |

### Storage Locations

- **Proposal attachments:** `storage/app/public/proposal-attachments/`
- **Team photos:** `storage/app/public/team/`

## Email Configuration (Mailgun)

Two SMTP mailers configured via Mailgun:

- `mailgun_form` - Contact form submissions
- `mailgun_request` - Proposal request submissions

### Testing Email

```bash
# Simple test
php artisan mail:test your@email.com

# Test proposal email template
php artisan mail:test your@email.com --mailer=mailgun_request --type=proposal

# Test contact email template
php artisan mail:test your@email.com --mailer=mailgun_form --type=contact
```

## Admin Panel

Access at `/admin` with the following features:

- **Pages** - Manage static pages
- **Team Members** - Manage team with photo upload and drag-drop reordering
- **Other Services** - Manage services on homepage
- **Achievements** - Manage achievements/certifications section
- **Proposals** - View and manage submitted proposals
- **Activity Log** - Track admin actions
- **Site Settings** - Configure site-wide settings

## Development Commands

```bash
# Clear all caches
php artisan cache:clear && php artisan route:clear && php artisan view:clear

# Run migrations
php artisan migrate

# Restart Apache after PHP config changes
sudo systemctl restart apache2
```
# logicenvironmental-project
