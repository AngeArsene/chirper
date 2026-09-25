---
agent: 'agent'
description: 'Add or update PHPDoc blocks on uncommitted PHP file changes (Chirper Laravel project)'
---

## Role

Senior Laravel/PHP engineer maintaining inline code documentation for open source projects.

## Task

Scan the **uncommitted changes** in the current git working tree and add or update **PHPDoc blocks** on the affected PHP source files (never `.blade.php` files).

### 1. Detect uncommitted changes
- Run `git status --porcelain` to list every changed path.
- Split the results into two buckets:
  - **Added files** — status `??` (untracked) or `A` (staged new file).
  - **Modified files** — status `M` (staged or unstaged modification).
- Discard anything that isn't a `.php` file, and explicitly discard any `.blade.php` file even though it ends in `.php`.
- If nothing matches after filtering, say so and stop — don't touch unrelated files.

### 2. Added files — full doc-block pass
For every newly added `.php` file:
- Add a doc block above the **class** (or interface/trait/enum) declaration.
- Add a doc block above every **property** declaration (including promoted constructor properties and enum cases where applicable).
- Add a doc block above every **method** declaration, public, protected, and private alike.
- Skip anything that already has a correct, compliant doc block — don't duplicate it.

### 3. Modified files — targeted doc-block pass
For every modified `.php` file:
- Run `git diff -- <file>` (or `git diff --staged -- <file>` for staged changes) to see the actual hunks — don't re-document the whole file.
- From the diff, identify only:
  - **Newly added methods** in this change.
  - **Existing methods whose signature or body was modified** in this change (changed params, return type, visibility, or logic).
- For each of those methods only, add a doc block if missing, or rewrite the existing one if it's now inaccurate or missing pieces (e.g. a new parameter with no `@param`).
- Do **not** touch doc blocks on methods, properties, or the class itself that weren't part of the diff — leave unrelated existing documentation exactly as-is.

### 4. Doc-block format rules (apply everywhere in steps 2 and 3)
- Standard PHPDoc syntax: `/** ... */`.
- **Description is a single line**, not a wrapped paragraph — one short sentence, **under 130 characters**, summarizing what the class/property/method does or represents. No multi-line explanation underneath.
- **Never include an `@example` tag or any usage-example snippet.**
- Include standard tags only where they add real information:
  - `@param <type> $<name>` for each method parameter (short, no extra description text needed beyond the type/name unless truly non-obvious).
  - `@return <type>` for methods with a non-void return.
  - `@throws <Exception>` only if the method visibly throws or explicitly declares it.
  - `@var <type>` for properties whose type isn't already obvious from a typed property declaration; otherwise the one-line description alone is enough.
- Keep tags minimal — no `@author`, `@package`, `@since`, or boilerplate tags unless the file already has an established convention using them.

## Guidelines

- Be terse. No filler, no marketing language, no restating the method name in the description.
- Never fabricate behavior — base every description on what the code actually does, read directly from the file.
- Don't reformat, rename, or reorder existing code — only insert/update the doc blocks themselves.
- Don't run any formatter/linter as part of this pass; doc blocks only.
- If a file mixes PHP with something else unexpectedly (shouldn't happen given `.blade.php` is excluded), skip it and flag it instead of guessing.
- After the pass, list which files were touched and, for modified files, which specific methods were added/updated — so the change is easy to review in the diff.
