# LaQuestion ES

Plataforma integral multiplataforma para la gestión, distribución y análisis de encuestas corporativas en tiempo real, compuesta por una API REST centralizada, un panel administrativo web y una aplicación móvil.

## Descripción del Proyecto

**LaQuestion ES** centraliza el ciclo de vida completo de encuestas identificadas y anónimas, permitiendo su creación y administración desde un entorno web ejecutivo y su respuesta ágil desde dispositivos móviles mediante enlaces directos o códigos QR. El sistema incluye analítica en tiempo real con indicadores clave de rendimiento (KPIs) segmentados por unidad organizacional y categoría.

### Arquitectura y Stack Tecnológico

* **Backend (API REST):** PHP 8.1+ / Laravel 10 con autenticación basada en tokens JWT (`backend/`).
* **Panel Web Administrativo:** Vue.js 3 + Vuetify + Pinia (`frontend/`).
* **Aplicación Móvil:** Ionic Framework + Vue 3 / Capacitor (`FrontedIonic/LaQuestionES-Ionic/`)[cite: 11, 21].
* **Base de Datos:** MySQL / MariaDB (`encuestas_mc.sql`)[cite: 11, 21].

---

## Requisitos Previos

* PHP >= 8.1 y Composer
* Node.js >= 18 y npm
* MySQL / MariaDB (XAMPP, Laragon o servidor local)
* Ionic CLI (`npm install -g @ionic/cli`)

---

## Guía de Instalación y Despliegue Local

### 1. Clonar el repositorio

```bash
git clone [https://github.com/Danny4lex/LaQuestionES-App.git](https://github.com/Danny4lex/LaQuestionES-App.git)
cd LaQuestionES-App
