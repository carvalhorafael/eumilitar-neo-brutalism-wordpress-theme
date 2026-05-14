import { expect, test } from "@playwright/test";

async function loginAsAdmin(page) {
  await page.goto("/wp-login.php");
  await page.locator("#user_login").fill("admin");
  await page.locator("#user_pass").fill("password");
  await page.locator("#wp-submit").click();
  await page.waitForURL(/\/wp-admin\//);
}

test.describe("EuMilitar theme editor contracts", () => {
  test("exposes EuMilitar patterns to the block editor", async ({ page }) => {
    test.skip(test.info().project.name !== "chromium", "Editor smoke runs only on desktop.");

    await loginAsAdmin(page);
    await page.goto("/wp-admin/post-new.php");

    await page.waitForFunction(() => {
      const core = window.wp?.data?.select("core");
      const patterns = core?.getBlockPatterns?.();

      return Array.isArray(patterns) && patterns.some((pattern) => pattern.name === "eumilitar/hero");
    });

    const patternNames = await page.evaluate(() => {
      return window.wp.data
        .select("core")
        .getBlockPatterns()
        .map((pattern) => pattern.name)
        .filter(Boolean);
    });

    expect(patternNames).toEqual(
      expect.arrayContaining([
        "eumilitar/hero",
        "eumilitar/faq",
        "eumilitar/landing-page",
        "eumilitar/sidebar-blog",
        "eumilitar/after-post-cta",
        "eumilitar/capture-compact",
      ])
    );
  });

  test("opens the widgets editor without deprecated script notices", async ({ page }) => {
    test.skip(test.info().project.name !== "chromium", "Widgets editor smoke runs only on desktop.");

    await loginAsAdmin(page);
    await page.goto("/wp-admin/widgets.php");

    await expect(page.locator("body")).not.toContainText("wp_enqueue_script()");
    await expect(page.locator("body")).not.toContainText("wp-editor");
  });
});
