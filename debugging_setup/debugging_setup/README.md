# WEB-250 — Debugging Setup

**This README is your graded debugging notebook.** Complete the TODOs below with your **own** observations after using VS Code + Xdebug. Do not paste `phpinfo()` output or anything confidential.

## Local setup

- Operating system and local server (Mac/MAMP or Windows/XAMPP): Windows / XAMPP
- PHP version shown in the **browser's phpinfo**: TODO
- Xdebug version: 3.5.3
- Active `php.ini` path (no secrets): TODO
- Xdebug / VS Code port (recommended 9003): 9003 (`xdebug.client_port=9003` in php.ini and `"port": 9003` in `.vscode/launch.json`)
- Local Apache port (our class uses 55000): 80 (XAMPP default; my local URLs use `http://localhost/` with no port number)
- Mac/MAMP FastCGI `-idle-timeout 600` configured? (Windows: N/A): N/A (Windows)
- Mac/MAMP 45-second breakpoint pause, Step Over, Continue test result (Windows: N/A): N/A (Windows)
- Local exercise index URL: http://localhost/web250/debugging_setup/debugging_setup/index.php
- Hosted exercise index URL: http://web250.joseo27.sg-host.com/

**php.ini Xdebug settings used:** `zend_extension = xdebug`, `xdebug.mode=debug,develop`, `xdebug.start_with_request=yes`, `xdebug.client_host=127.0.0.1`, `xdebug.client_port=9003`.

**Sandbox check:** VS Code stopped at the breakpoint on line 17 of `sandbox_breakpoints.php` before the addition ran. Variables showed `$today = 2`, `$yesterday = 3`, `$total = 0`. After Step Over, `$total` was 5.

## Exercise 01 — Variables and Watch

- Prediction for `$observations` before the `+=` line: 3
- Value before Step Over: 3 (paused on line 12; Watch and Variables both showed `$observations = 3`)
- Value after Step Over: 5
- What you learned about the breakpoint and Watch: The breakpoint pauses PHP *before* the line runs, so the value still showed 3 while the `+=` line was highlighted. Step Over ran that one line, and Watch then showed 5 because `+= 2` added 2 to the existing value.
- Screenshot: `evidence/debugging-images/step01.png` — Paused on `$observations += 2;` with `$observations = 3` in Variables and Watch. Browser output: `evidence/debugging-images/step01 output.png`.

## Exercise 02 — Loop and conditional breakpoint

- Predicted total and average: Total 10, average 2.50
- `$total` after the first two iterations: 6 (at the first two pauses, before the line ran, `$total` was 0 and then 2)
- Values seen when `$dayIndex === 2` (index, count, total): index 2, count 1, total 6 before the line runs (7 after Step Over)
- Why the conditional breakpoint helped: The normal breakpoint inside the loop paused on every pass (four times). The condition `$dayIndex === 2` skipped straight to the third pass, so I could check that one iteration without clicking Continue repeatedly.
- Screenshot: `evidence/debugging-images/step02.png` — First pass of the loop: `$dayIndex = 0`, `$count = 2`, `$total = 0` in Watch. Browser output (`Total sightings: 10`, `Average per day: 2.50`): `evidence/debugging-images/step02 output.png`.

## Exercise 03 — Step Into / Step Out / Call Stack

- Predicted output: `Eastern Towhee: 2 sightings`
- Which function called `formatObservation()`?: `describeBird()` (line 15). The Call Stack showed `formatObservation` on top, then `describeBird`, then `{main}`.
- What Step Into showed that Step Over would skip: Step Into went inside `describeBird()` and then inside `formatObservation()`, where I could see the local variables `$name = "Eastern Towhee"`, `$count = 2`, and `$word` (uninitialized, then `'sightings'`). Step Over would have run the whole function call as one step without showing those.
- Where Step Out returned you: Back to `describeBird()` at line 15, where the returned string is assigned to `$report`. `formatObservation` was removed from the top of the Call Stack.
- Screenshot: `evidence/debugging-images/step03.png` — Paused inside `formatObservation()` at line 9, with three frames in the Call Stack. Browser output: `evidence/debugging-images/step03 output.png`.

## Exercise 04 — Find and fix the bug

- Original incorrect browser output: `Birds counted: 4`
- Values you observed while stepping through the loop: `$total` was replaced on each pass instead of growing: 2, then 3, then 4.
- Original error and minimal correction (in your words): The loop used `=` instead of `+=`, so `$total` was overwritten with each count instead of adding to it. Changing `=` to `+=` makes the loop add every count.
- Corrected output: `Birds counted: 9`
- Why PHP did not raise an exception: `$total = $count;` is valid PHP, so nothing crashes. It is a logic error: the code runs fine but does the wrong math.
- What Watch revealed that a single final print could not: The final print only showed the wrong answer (4). Watching `$total` on each pass showed it being replaced by each count instead of growing, which pointed straight to the `=` on that line.
- Screenshot: TODO

## How to view this project

- Local: Open `web250/debugging_setup/index.php` through your MAMP/XAMPP browser URL.
- Webhost: Open the course index and follow the Debugging Setup link.
- GitHub: Link to this folder on `main` in the Moodle Comments area.

**Safety reminder:** Never commit or deploy `php.ini`, `_local_phpinfo.php`, credentials, or logs. The project-level `.vscode/launch.json`, this README, and evidence screenshots belong on **GitHub** but **not** on the public webhost. Never activate Xdebug on your public webhost.
