# Imagewize Mega Menu

A WordPress mega menu package built for Acorn/Sage-based themes. This package enhances navigation menus with advanced mega menu functionality including categorized groups, descriptions, and featured content areas.

## Features

- Responsive mega menu with mobile toggle support
- Customizable menu item fields for enhanced navigation
- Group menu items into categories within dropdown
- Add descriptions to menu items
- Include featured images and rich text content in mega dropdowns
- Accessible navigation with proper ARIA attributes
- Built for use with Roots Sage themes using Acorn

## Requirements

- WordPress with a Sage 10+ theme
- Acorn framework
- Log1x/Navi package for menu handling
- Tailwind CSS (v4.x) for styling

## Installation

You can install this package with Composer:

```bash
composer require imagewize/img-mega-menu
```

You can publish the config file with:

```shell
$ wp acorn vendor:publish --provider="Imagewize\ImgMegaMenu\Providers\ImgMegaMenuServiceProvider"
```

## Usage

From a Blade template:

```blade
@include('img-mega-menu::mega-menu', ['name' => 'primary_navigation'])
```

Where 'primary_navigation' is the name of your registered WordPress menu.

## Menu Fields

When editing your WordPress menu items, you'll have access to these additional fields:

1. **Category** - Group menu items in the mega dropdown (applies to child items)
2. **Description** - Short text that appears under the menu item in the mega dropdown
3. **Featured Image** - URL of an image to display in the featured section (for parent items)
4. **Featured Text** - Rich text content to display in the featured section (for parent items)

## Customization

You can customize the appearance of the mega menu by modifying the Blade template after publishing the views:

```shell
$ wp acorn vendor:publish --provider="Imagewize\ImgMegaMenu\Providers\ImgMegaMenuServiceProvider" --tag="views"
```

The mega menu is built with accessibility in mind and uses Tailwind CSS v4 for styling. You may need to customize the Tailwind classes to match your theme's design system.
