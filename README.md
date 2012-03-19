Disable Template Editor [EE1]
===

This extension for **ExpressioneEngine 1.6.x (EE1)** gives you the ability to disable template management in the control panel. The initiative behind the idea is to prevent users (with Template access) modifiying files that are in source control inevitably making it more inefficient to keep things in sync.

This extension is ported over from the [Disable-Template-Editor](https://github.com/bunchjesse/Disable-Template-Editor) for EE2 by [bunchjesse](https://github.com/bunchjesse).

What it does
---
* Disables the ability to create/modify/delete template groups
* Template editor becomes *read-only* to allow code viewing and prevents editing
* Hides the template revision list (if we're in source control, this feature becomes redundant entirely)
* Hides `<form>` actions/notes in the template editor

Installation
---
Add the file `ext.disable_template_editor.php` to the `system/extensions` directory and enable through the extensions utility in control panel. Simples.