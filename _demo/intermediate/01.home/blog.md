---
title: Home
metadata:
    'twitter:card': summary
    'twitter:site': '@hibbittsdesign'
    'twitter:title': 'Course Hub Title'
    'twitter:description': 'Course Hub Description'
    'twitter:image': ''
sitemap:
    changefreq: monthly
body_classes: 'header-image fullwidth'
content:
    items: '@self.children'
    limit: 20
    order:
        by: date
        dir: desc
    pagination: '1'
hide_git_sync_repo_link: false
modular_content:
    items: '@self.modular'
    order:
      by: default
      custom:
          - _important-reminders
          - _unit-preparations
feed:
    description: 'Course Hub Description'
    limit: 10
---
