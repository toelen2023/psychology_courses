# psychology_courses
# Psychology Courses Plugin
> Custom WordPress plugin for managing psychology courses, teachers, reviews

> Status: 🚧 In active development

---

# Project Goals

The plugin is intended for educational centers that offer recurring psychology courses.

The same course can be launched multiple times during a year, with different teachers and different start dates.

The plugin should eliminate duplicated content and provide a single source of truth for each entity.

---

# Main Entities

## Course

A course contains static information that does not depend on a specific launch.

Examples:

- title
- description
- program
- duration
- prices
- categories
- featured image
- SEO

Examples:

- Basics of Psychology
- CBT
- Child Psychology


---

## Course Stream

A stream represents a specific launch of a course.

A stream contains dynamic information.

Examples:

- related course
- start date
- end date
- teachers
- status
- available places

Examples:

Course:
    Basics of Psychology

Streams:

- September 2026
- October 2026
- December 2026

Each stream may have different teachers.

---

## Teacher

Separate Custom Post Type.

Contains:

- name
- photo
- description
- biography
- position

One teacher can participate in many streams.

---
## Review

A review belongs to a specific course stream.

This allows displaying:

- reviews on the course page
- reviews for a teacher
- reviews for a specific stream

without duplicating data.

---

# Relations

Course
↓
Course Stream
↓
Teacher
Course Stream
↓
Review

---

# WordPress Structure

## Custom Post Types

- course
- course_stream
- teacher
- review

---

## Taxonomies

Current:

- course_category

Terms:

- For psychologists
- For beginners

Possible future taxonomies:

- Topics
- Format
- Language
- Level

---

# Course Page

Displays:

- course information
- nearest stream
- optionally several upcoming streams
- teachers participating in active streams
- reviews

---

# Design Principles

## Single Source of Truth

Every piece of information should exist only once.

Example:

Teachers are attached only to Course Streams.

Course pages determine their teachers automatically.

---

## Separation of Responsibilities

Each PHP class should have one responsibility.

Example:

Course_Post_Type

only registers CPT.

Course_Metabox

only renders admin fields.

Course_Save

only saves data.

---

## Extensibility

Architecture should allow future features without major refactoring.

Possible future features:

- online registration
- payment gateways
- student dashboard
- certificates
- webinars
- Zoom links
- downloadable materials
- attendance tracking

---

# Development Status

Current phase:

- project architecture
- data model
- folder structure

Next phase:

- plugin bootstrap
- CPT registration
- metaboxes
- saving data

# Architecture Decisions

This document describes the current architecture.

The data model may evolve during development as new business requirements appear.

Changes are expected and considered part of the design process.