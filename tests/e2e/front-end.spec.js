import AxeBuilder from "@axe-core/playwright";
import { expect, test } from "@playwright/test";

test.describe("EuMilitar theme front end", () => {
  test("renders the landing page and loads theme assets", async ({ page }) => {
    const consoleErrors = [];
    page.on("console", (message) => {
      if (message.type() === "error") {
        consoleErrors.push(message.text());
      }
    });

    await page.goto("/");

    await expect(page.locator(".ds-hero")).toBeVisible();
    await expect(page.locator(".ds-hero__title")).toBeVisible();
    await expect(page.locator(".ds-faq")).toBeVisible();
    await expect(page.locator("[data-accordion-root]")).toBeVisible();
    await expect(page.locator('script[src*="assets/dist/assets/main-"]')).toHaveCount(1);
    await expect(page.locator('link[href*="assets/dist/assets/main-"]')).toHaveCount(1);
    expect(consoleErrors).toEqual([]);
  });

  test("enhances the FAQ accordion interaction", async ({ page }) => {
    await page.goto("/");

    const accordion = page.locator("[data-accordion-root]");
    const trigger = accordion.locator("[data-accordion-trigger]").first();
    const panel = accordion.locator("[data-accordion-panel]").first();

    await expect(trigger).toHaveAttribute("aria-expanded", "false");
    await expect(panel).toBeHidden();

    await trigger.click();

    await expect(trigger).toHaveAttribute("aria-expanded", "true");
    await expect(panel).toBeVisible();
  });

  test("has no automatically detectable WCAG A/AA violations on the landing page", async ({ page }) => {
    await page.goto("/");

    const results = await new AxeBuilder({ page })
      .withTags(["wcag2a", "wcag2aa", "wcag21a", "wcag21aa"])
      .analyze();

    expect(results.violations).toEqual([]);
  });
});
