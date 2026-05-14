import { readFileSync } from "node:fs";

const tagName = process.argv[2] ?? process.env.TAG_NAME;

if (!tagName) {
  throw new Error("Missing release tag. Pass vX.Y.Z as an argument or TAG_NAME.");
}

if (!/^v\d+\.\d+\.\d+$/.test(tagName)) {
  throw new Error(`Invalid release tag "${tagName}". Expected vX.Y.Z.`);
}

const expectedVersion = tagName.slice(1);
const packageJson = JSON.parse(readFileSync("package.json", "utf8"));
const styleCss = readFileSync("style.css", "utf8");
const readme = readFileSync("readme.txt", "utf8");

const styleVersion = styleCss.match(/^Version:\s*(.+)$/m)?.[1]?.trim();
const stableTag = readme.match(/^Stable tag:\s*(.+)$/m)?.[1]?.trim();

const mismatches = [
  ["package.json", packageJson.version],
  ["style.css Version", styleVersion],
  ["readme.txt Stable tag", stableTag],
].filter(([, version]) => version !== expectedVersion);

if (mismatches.length > 0) {
  console.error(`Release tag ${tagName} expects version ${expectedVersion}.`);
  for (const [source, version] of mismatches) {
    console.error(`- ${source}: ${version ?? "missing"}`);
  }

  process.exit(1);
}

console.log(`Release version ${expectedVersion} matches ${tagName}.`);
