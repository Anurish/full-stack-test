# Answers to technical questions

## 1) How long did you spend on the coding test? What would you add to your solution if you had more time?

I spent 2 days on the coding test.

If I had more time, I would improve the solution in the following ways:

- Add form validation, error handling, and loading states for a better user experience.
- Make the CRUD flow more polished with inline editing, confirmation dialogs, and success/error notifications.
- Refactor the PHP code into a cleaner structure using reusable functions or a small MVC-style organization.
- Improve accessibility, including keyboard navigation, focus states, and ARIA attributes where needed.
- Add stronger responsive refinement for tablets and smaller screens.
- Write automated tests for the core CRUD operations and critical UI interactions.
- Optimize the database layer further with better indexing and prepared queries throughout.

## 2) How would you track down a performance issue in production? Have you ever had to do this?

To track down a performance issue in production, I would start by identifying whether the slowdown is coming from the frontend, backend, database, or infrastructure.

My approach would be:

1. Confirm the symptom and identify the exact page, API endpoint, or user flow.
2. Check logs and metrics such as response times, CPU/memory usage, and slow queries.
3. Isolate the bottleneck and determine whether the issue is caused by SQL, caching, network latency, or frontend rendering.
4. Use profiling tools to inspect the slowest layer.
5. Compare against recent code or configuration changes.
6. Apply the smallest safe fix first, then measure again.
7. Add monitoring or regression checks to prevent recurrence.

Yes, I have worked on performance-related issues before. The key is to measure before changing anything so that the actual bottleneck is fixed instead of being guessed.

## 3) Please describe yourself using JSON

```json
{
  "name": "Anurish",
  "role": "Software Developer",
  "skills": [
    "PHP",
    "MySQL",
    "WordPress",
    "Laravel",
    "React",
    "Node.js",
    "Nextjs",
    "JavaScript",
    "HTML",
    "CSS"
  ],
  "interests": [
    "full stack development",
    "backend development",
    "Gen AI",
    "gym"
  ],
  "working_style": [
    "detail-oriented",
    "problem-solving focused",
    "always improving"
  ],
  "location": "India",
  "goal": "To build clean, scalable, and user-focused web applications"
}
```
