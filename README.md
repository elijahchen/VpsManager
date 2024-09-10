# FreeSCOUT VPS Manager Module

## Overview

The FreeSCOUT VPS Manager module is an extension for FreeSCOUT that integrates with the UpCloud API to manage VPS instances. This module allows you to view, monitor, and manage your VPS instances directly from your FreeSCOUT interface.

## Features

- List all VPS instances with the "VPS" tag from UpCloud
- Display key information for each instance:
  - CID (Customer ID)
  - Full Name
  - Email
  - IP Address
  - Creation Date
  - Status
  - Days until expiration
- Color-coded expiration dates for easy visualization:
  - Green: More than 15 days
  - Yellow: 7-15 days
  - Orange: 3-7 days
  - Red: Less than 3 days
- Perform actions on VPS instances:
  - Restart
  - Terminate
  - Report issue to tech team
  - Send notice to client
  - Extend expiration (7, 15, or 30 days)
- Automatic daily update of expiration countdown

## Installation

1. Ensure you have FreeSCOUT installed and properly configured.

2. Download the VPS Manager module files and place them in your FreeSCOUT modules directory:

   ```
   /path/to/freescout/Modules/VpsManager/
   ```

3. Install the module dependencies:

   ```
   cd /path/to/freescout
   composer require guzzlehttp/guzzle
   ```

4. Add your UpCloud API credentials to your FreeSCOUT .env file:

   ```
   UPCLOUD_USERNAME=your_username
   UPCLOUD_PASSWORD=your_password
   ```

5. Run the module migration:

   ```
   php artisan module:migrate VpsManager
   ```

6. Clear the application cache:

   ```
   php artisan cache:clear
   ```

7. Restart your web server.

8. Log in to your FreeSCOUT admin panel and navigate to Modules. Find "VPS Manager" in the list and click "Activate".

## Usage

Once installed and activated, you can access the VPS Manager from the main menu in FreeSCOUT. Click on "VPS Manager" to view and manage your VPS instances.

## Uninstallation

To uninstall the VPS Manager module:

1. Deactivate the module from the FreeSCOUT admin panel:
   - Go to Modules
   - Find "VPS Manager"
   - Click "Deactivate"

2. Remove the module files:

   ```
   rm -rf /path/to/freescout/Modules/VpsManager
   ```

3. Remove the database tables:

   ```
   php artisan migrate:rollback --path=Modules/VpsManager/Database/Migrations
   ```

4. Clear the application cache:

   ```
   php artisan cache:clear
   ```

5. Restart your web server.

## Support

If you encounter any issues or have questions about the VPS Manager module, please open an issue on our GitHub repository or contact our support team.

## License

This module is open-source software licensed under the MIT license.