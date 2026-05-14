import { mkdir, readFile, writeFile } from "node:fs/promises";
import { dirname, relative, resolve } from "node:path";

const root = process.cwd();
const cloverPath = resolve(root, "coverage/php/clover.xml");
const summaryPath = resolve(root, "coverage/php/summary.md");
const marker = "<!-- eumilitar-php-coverage -->";
const themePathMarker = "/wp-content/themes/eumilitar-neo-brutalism-wordpress-theme/";

function attributes(fragment) {
  return Object.fromEntries(
    [...fragment.matchAll(/([a-zA-Z_:-]+)="([^"]*)"/g)].map(([, key, value]) => [key, value])
  );
}

function percent(covered, total) {
  if (!total) {
    return "n/a";
  }

  return `${((covered / total) * 100).toFixed(1)}%`;
}

function formatRows(rows) {
  if (!rows.length) {
    return "_No covered theme files found._";
  }

  return [
    "| File | Lines | Methods | Classes |",
    "|---|---:|---:|---:|",
    ...rows.map(
      (row) =>
        `| \`${row.path}\` | ${percent(row.coveredStatements, row.statements)} | ${percent(
          row.coveredMethods,
          row.methods
        )} | ${percent(row.coveredClasses, row.classes)} |`
    ),
  ].join("\n");
}

const xml = await readFile(cloverPath, "utf8");
const projectMatch = xml.match(/<project\b[\s\S]*?<metrics\b([^>]*)\/>\s*<\/project>/);

if (!projectMatch) {
  throw new Error(`Could not find project metrics in ${relative(root, cloverPath)}`);
}

const project = attributes(projectMatch[1]);
const totals = {
  statements: Number(project.statements || 0),
  coveredStatements: Number(project.coveredstatements || 0),
  methods: Number(project.methods || 0),
  coveredMethods: Number(project.coveredmethods || 0),
  classes: Number(project.classes || 0),
  coveredClasses: Number(project.coveredclasses || 0),
};

const files = [...xml.matchAll(/<file\b([^>]*)>([\s\S]*?)<\/file>/g)]
  .map(([, fileAttrs, body]) => {
    const file = attributes(fileAttrs);
    const metricsMatch = body.match(/<metrics\b([^>]*)\/>/);

    if (!metricsMatch) {
      return null;
    }

    const metrics = attributes(metricsMatch[1]);
    const rawPath = file.name || "unknown";
    const markerIndex = rawPath.indexOf(themePathMarker);
    const path =
      markerIndex >= 0
        ? rawPath.slice(markerIndex + themePathMarker.length)
        : relative(root, rawPath).replaceAll("\\", "/");

    return {
      path,
      statements: Number(metrics.statements || 0),
      coveredStatements: Number(metrics.coveredstatements || 0),
      methods: Number(metrics.methods || 0),
      coveredMethods: Number(metrics.coveredmethods || 0),
      classes: Number(metrics.classes || 0),
      coveredClasses: Number(metrics.coveredclasses || 0),
    };
  })
  .filter(Boolean)
  .filter((file) => file.path === "functions.php" || file.path.startsWith("inc/"))
  .sort((a, b) => {
    const aCoverage = a.statements ? a.coveredStatements / a.statements : 1;
    const bCoverage = b.statements ? b.coveredStatements / b.statements : 1;

    return aCoverage - bCoverage || a.path.localeCompare(b.path);
  });

const lowest = files.slice(0, 5);
const summary = `${marker}
## PHP Test Coverage

Coverage is informational and does not block this PR.

| Metric | Coverage |
|---|---:|
| Lines | ${percent(totals.coveredStatements, totals.statements)} |
| Methods | ${percent(totals.coveredMethods, totals.methods)} |
| Classes | ${percent(totals.coveredClasses, totals.classes)} |

Lowest covered theme files:

${formatRows(lowest)}

HTML artifact: \`php-coverage-html\`
`;

await mkdir(dirname(summaryPath), { recursive: true });
await writeFile(summaryPath, summary);

console.log(summary);
