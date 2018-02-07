---
title: Home
body_classes: 'header-image fullwidth'
child_type: item
content:
    items: '@self.children'
    limit: 20
    order:
        by: date
        dir: asc
    pagination: '1'
hide_blog_sidebar: true
post_icon: calendar-o
continue_link_as_button: false
modular_content:
    items: '@self.modular'
    order:
        by: default
        custom:
            - _important-reminders
            - _unit-preparations
feed:
    description: 'Grav CMS Open Course Hub Description'
    limit: 10
---
