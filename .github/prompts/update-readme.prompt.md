---
agent: 'agent'
description: 'Update README.md to reflect new functionality introduced in the current feature branch of the Chirper Laravel project'
---

## Role

Senior Laravel engineer maintaining documentation for open source projects.

## Task

**This prompt updates an existing `README.md` — it never creates one from scratch.** Assume `README.md` already exists at the repo root. The goal is narrow: surface whatever new functionality the *current feature branch* adds, without disturbing anything already accurate in the file.

### 1. Identify what's new on this branch
- Run `git log --oneline -20` and `git diff main...HEAD --stat` (or the equivalent base branch) to see which files changed on the current branch.
- Run `git status` to confirm the current branch name.
- Focus your source review only on the changed/added files from that diff — routes, controllers, models, policies, middleware, migrations, seeders, config, `.env.example`, `composer.json`/`package.json` — plus enough surrounding context to describe each change accurately (real class/method names, real middleware aliases, real schema columns).
- Do not re-audit or re-describe functionality that already exists on the base branch and is already correctly documented in the current README.

### 2. Sections that must stay untouched
The following must be preserved **exactly as currently written, character for character**, with one narrow exception noted in step 3:
- Title & tagline block (the `# Chirper` heading and its opening description paragraph).
- Every other section of the README not explicitly called out in steps 3–6 below (e.g. Usage, any status/notes sections not covered here).
- Within "What the app does": the existing paragraph text is not to be edited, reworded, or reordered.

### 3. "What the app does" — append only
Locate:

```markdown
## What the app does

This repository is a small Laravel web application. Authenticated users can publish short messages to a paginated home feed, edit or delete their own chirps, and update their profile details. The middleware and policy layer protect the authenticated-only pages and authorize ownership-sensitive actions.
```

Leave this paragraph exactly as-is. Add **one brief additional sentence** directly after it, in the same paragraph or as a short following sentence, describing — in plain, non-technical terms — what a user can *now also do* because of the current branch's new functionality, provided it isn't already covered by the existing text. Do not restate anything already implied above. If the branch adds no user-facing capability (e.g. it's purely internal/refactor work), skip this addition and say so in your summary instead of inventing a sentence.

### 4. Features section — add, don't rewrite
Append new bullet(s) describing the branch's functionality, matching the existing bullet style and level of technical specificity (real table/column names, real controller/method names, real middleware or authorization mechanics — never generic phrasing). Example of the expected specificity, from the current file:

```markdown
- The schema includes a users table, sessions table, password reset tokens, and a `chirps` table with a nullable unique `idempotency_key` column added in a later migration.
```

Do not edit or remove existing bullets unless a bullet describes something the branch has since removed or replaced (see step 5's removal principle — same logic applies here: if a feature bullet is now factually wrong because of this branch, correct only that bullet, minimally).

### 5. Project structure — sync, don't rebuild
Update the fenced project-structure tree:
- **Add** entries for any new files/folders introduced on this branch, with a comment naming the actual class/file (e.g. `# ChirpLike model` not `# new model`).
- **Remove** entries for any files/folders the branch deletes or renames.
- Leave every other line in the tree untouched.

### 6. Quick start — clone step check
Inspect the **Quick start** subsection's command sequence.
- If the first instruction is not a `git clone` step, **insert one** as the new first instruction (e.g. `git clone <repo-url> && cd chirper`, using the actual repo URL if known, otherwise a placeholder consistent with the repo's remote).
- If a clone step is already first, leave the sequence exactly as-is.
- Do not remove, reorder, or reword any existing command or instruction in either the Quick start or Manual steps sequence, regardless of the clone-step outcome.

### 7. Status footer
Update:

```markdown
## Status

_Last synced with commit cde3b08c86fe6923c62007cb88aa1e956770d2c5 (2026-08-08)_
```

Replace the hash and date with the current `HEAD` commit hash (`git rev-parse HEAD`, or the short form matching the existing style) and its commit date. Nothing else in this section changes.

## Guidelines

- Be terse. No filler, no marketing language.
- GitHub Flavored Markdown, relative links only.
- Never fabricate command names, class names, file paths, table/column names, or validation rules — verify each against the actual branch diff before writing it in.
- If the current branch introduces nothing README-worthy beyond what's already documented, say so explicitly and only update the Status footer.
- Every edit must be additive or corrective-and-minimal — never a rewrite of untouched sections, never a rewording of preserved text.
