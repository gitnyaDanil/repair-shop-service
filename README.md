# 🚀 Workshop Order Management System (OMS)

> A secure, web-based Order Management System designed to automate workflow calculations, streamline repair order lifecycle tracking, and digitalize operations for manufacturing and metal workshop MSMEs. 

[![Framework: Laravel 11.x](https://img.shields.io/badge/Framework-Laravel%2011.x-orange.svg)](https://laravel.com/)
[![Language: PHP](https://img.shields.io/badge/Language-PHP%208.x-purple.svg)](https://www.php.net/)
[![Frontend: Bootstrap](https://img.shields.io/badge/Frontend-Bootstrap-blueviolet.svg)](https://getbootstrap.com/)
[![Database: MySQL](https://img.shields.io/badge/Database-MySQL-blue.svg)](https://www.mysql.com/)
[![Methodology: Scrum/Agile](https://img.shields.io/badge/Methodology-Scrum%20%2F%20Agile-success.svg)](https://scrumguides.org/)

---

## 📌 Overview & Real-World Impact

Small and Medium Enterprises (MSMEs) contribute significantly to Indonesia's GDP, yet many traditional workshops suffer from severe operational bottlenecks due to manual bookkeeping and fragmented tracking. 

This enterprise-grade web application replaces paper-reliant workflows with a centralized digital system. It directly mitigates critical operational challenges by eliminating manual mathematical inaccuracies, solving data loss vulnerabilities (due to physical environmental damage), and optimizing file accessibility via custom query filtering.

### Key Business Outcomes
* **Workflow Automation:** Transitions manual calculations into programmatic operations, eliminating human calculation error.
* **Data Durability:** Replaces brittle physical folders with a structured database, protecting business-critical documents against loss or environmental damage (e.g., floods/pests).
* **Operational Transparency:** Empowers workshop managers to track a repair order from initial physical intake down to final invoicing and payment confirmation.

---

## 🏗️ System Architecture & Engineering

The platform is engineered using modern object-oriented principles, adopting an application-independent data layout and high-cohesion design patterns.

### Technical Stack
* **Backend Ecosystem:** PHP 8.x utilizing the **Laravel 11.x** Framework (Model-View-Controller architecture for scalable server-side logic).
* **Frontend UI:** **Bootstrap Layout Library** layered with semantic HTML5, CSS3, and JavaScript to deliver an intuitive dashboard interface.
* **Database Engine:** **MySQL Relational Database** utilizing Eloquent ORM for secure database operations.
* **Modeling & Architecture:** Unified Modeling Language (UML) detailing custom Activity, Sequence, Class, Component, and Deployment diagrams to secure system infrastructure.

### Functional Modules
1.  **Authentication Control (`AuthController`):** Secure state management using password-hashing (`bcrypt`) alongside session termination protocols.
2.  **Customer Directory Management:** Robust CRUD data layers handling dynamic customer metadata.
3.  **Customer Interaction Registry:** Tracks ongoing communications and updates with stakeholders.
4.  **Service Catalog Configurator:** Manages custom shop repair variants, standardized costs, and technical specifications.
5.  **Repair Order Lifecycle Tracker:** The central orchestration engine mapping physical intake items into live digital statuses.
6.  **Billing & Invoice Generator:** Dynamically compiles associated service configurations and prints/downloads data-aligned business invoices.
7.  **Payment Tracker:** Handles payment validation histories paired explicitly to active invoice records.

---

## 📈 Agile / Scrum Implementation Journey

The development cycle strictly adopted a two-sprint iterative **Scrum Framework** to preserve architectural flexibility and fast velocity:

* **Sprint 1 (Core Foundations):** Built out core operational data structures—Focusing heavily on user login security, primary client/service data sets, processing logic for repair items, and basic transactional models (Invoices & Payments).
* **Sprint 2 (Advanced Discovery Layers):** Programmed specialized index parameters allowing rapid querying capabilities across clients, orders, status filters, and historical invoices to ensure frictionless navigation.

---

## 🧪 Quality Assurance & System Verification

To validate that the software met both strict engineering standards and end-user performance demands, two distinct QA strategies were applied:

### 1. Technical Functionality (Black Box Testing)
Rigorous application testing treating the codebase parameters externally. All critical endpoints—including logic flows for form validation, edge cases, secure parameter authentication, boundary inputs, and data persistence—were tested to ensure predictable, error-free outputs.

### 2. Practical Business Usability (User Acceptance Testing)
Conducted directly with real-world workshop operators to evaluate practical field performance. Utilizing a quantitative **Likert Scale (1-5)** matrix, the production-ready system achieved exemplary acceptance thresholds:

| Module System evaluated | Average Likert Score Value | Functional Interpretation |
| :--- | :---: | :--- |
| **Authentication Interface** | `5.0 / 5.0` | 🌟 Strongly Agree (Highly Intuitive & Secure) |
| **Repair Order Core Pipeline**| `4.0 / 5.0` | ✅ Agree (High Operational Standard) |
| **Invoice Processing Layer** | `4.0 / 5.0` | ✅ Agree (High Operational Standard) |
| **Payment Tracking Hub** | `4.0 / 5.0` | ✅ Agree (High Operational Standard) |


