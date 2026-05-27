# Role-Based Access Control (RBAC)

## Demo Login

| Role | Email | Password | Panel URL |
|------|-------|----------|-----------|
| **Admin** | admin@mobilehub.bd | admin123 | `/admin` |
| **Moderator** | mod@mobilehub.bd | mod123 | `/moderator` |
| **Customer** | customer@mobilehub.bd | customer123 | `/account` |

## Install (প্রথমবার)

1. XAMPP → **Apache** + **MySQL** Start
2. Browser: `http://localhost/mobile/public/install`
3. **Install Now** ক্লিক
4. Login page এ যান

## Permission Summary

### Admin — Full Access
- User add/delete, role change, block
- Product CRUD + delete
- All orders, cancel, analytics
- Settings, banners, coupons

### Moderator — Limited
- Product add/update/stock ✅
- Orders view + status update ✅
- ❌ Delete products, users, settings

### Customer
- Register, login, profile
- Cart, checkout, order history
- Cancel pending orders
