# WEB-250 — Debugging Setup

**This README is your graded debugging notebook.** Complete the TODOs below with your **own** observations after using VS Code + Xdebug. Do not paste `phpinfo()` output or anything confidential.

## Local setup

- Operating system and local server (Mac/MAMP or Windows/XAMPP): TODO
- PHP version shown in the **browser's phpinfo**: TODO
- Xdebug version: TODO
- Active `php.ini` path (no secrets): TODO
- Xdebug / VS Code port (recommended 9003): TODO
- Local Apache port (our class uses 55000): TODO
- Mac/MAMP FastCGI `-idle-timeout 600` configured? (Windows: N/A): TODO
- Mac/MAMP 45-second breakpoint pause, Step Over, Continue test result (Windows: N/A): TODO
- Local exercise index URL: TODO
- Hosted exercise index URL: TODO

## Exercise 01 — Variables and Watch

- Prediction for `$observations` before the `+=` line: TODO
- Value before Step Over: TODO
- Value after Step Over: TODO
- What you learned about the breakpoint and Watch: TODO
- Screenshot: `evidence/01_variables.png` — TODO caption

## Exercise 02 — Loop and conditional breakpoint

- Predicted total and average: TODO
- `$total` after the first two iterations: TODO
- Values seen when `$dayIndex === 2` (index, count, total): TODO
- Why the conditional breakpoint helped: TODO
- Screenshot: `evidence/02_conditional.png` — TODO caption

## Exercise 03 — Step Into / Step Out / Call Stack

- Predicted output: TODO
- Which function called `formatObservation()`?: TODO
- What Step Into showed that Step Over would skip: TODO
- Where Step Out returned you: TODO
- Screenshot: `evidence/03_call_stack.png` — TODO caption

## Exercise 04 — Find and fix the bug

- Original incorrect browser output: TODO
- Values you observed while stepping through the loop: TODO
- Original error and minimal correction (in your words): TODO
- Corrected output: TODO
- Why PHP did not raise an exception: TODO
- Screenshot: `evidence/04_fixed_bug.png` — TODO caption

## How to view this project

- Local: Open `web250/debugging_setup/index.php` through your MAMP/XAMPP browser URL.
- Webhost: Open the course index and follow the Debugging Setup link.
- GitHub: Link to this folder on `main` in the Moodle Comments area.

**Safety reminder:** Never commit or deploy `php.ini`, `_local_phpinfo.php`, credentials, or logs. The project-level `.vscode/launch.json`, this README, and evidence screenshots belong on **GitHub** but **not** on the public webhost. Never activate Xdebug on your public webhost.
