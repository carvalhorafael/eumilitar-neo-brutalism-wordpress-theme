import AxeBuilder from "@axe-core/playwright";
import { expect, test } from "@playwright/test";
import { execFileSync } from "node:child_process";

const runWpCli = (args) => {
  return execFileSync("npx", ["wp-env", "run", "cli", "wp", ...args], {
    encoding: "utf8",
    stdio: "pipe",
  }).trim();
};

const tryRunWpCli = (args) => {
  try {
    return runWpCli(args);
  } catch {
    return "";
  }
};

const setWpOption = (name, value) => {
  if (tryRunWpCli(["option", "get", name]) !== value) {
    runWpCli(["option", "update", name, value]);
  }
};

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

test.describe("EuMilitar blog templates", () => {
  test.skip(({ isMobile }) => isMobile, "Blog content setup mutates WordPress state once.");

  let blogPageId;
  let blogPageUrl;
  let frontPageId;
  let firstPostId;

  test.beforeAll(({}, testInfo) => {
    if (testInfo.project.name !== "chromium") {
      return;
    }

    const existingPosts = runWpCli(["post", "list", "--post_type=post", "--format=ids"]);
    const existingBlogPages = runWpCli(["post", "list", "--post_type=page", "--name=artigos-e2e", "--format=ids"]);
    const existingFrontPages = runWpCli(["post", "list", "--post_type=page", "--name=home-e2e", "--format=ids"]);

    if (existingPosts) {
      existingPosts.split(/\s+/).forEach((postId) => {
        tryRunWpCli(["post", "delete", "--force", postId]);
      });
    }

    if (existingBlogPages) {
      existingBlogPages.split(/\s+/).forEach((postId) => {
        tryRunWpCli(["post", "delete", "--force", postId]);
      });
    }

    if (existingFrontPages) {
      existingFrontPages.split(/\s+/).forEach((postId) => {
        tryRunWpCli(["post", "delete", "--force", postId]);
      });
    }

    blogPageId = runWpCli([
      "post",
      "create",
      "--post_type=page",
      "--post_status=publish",
      "--post_title=Artigos",
      "--post_name=artigos-e2e",
      "--post_content=Conteúdos e orientações para sua preparação.",
      "--porcelain",
    ]);
    frontPageId = runWpCli([
      "post",
      "create",
      "--post_type=page",
      "--post_status=publish",
      "--post_title=Home E2E",
      "--post_name=home-e2e",
      "--post_content=Página inicial temporária para testes.",
      "--porcelain",
    ]);

    setWpOption("show_on_front", "page");
    setWpOption("page_on_front", frontPageId);
    setWpOption("page_for_posts", blogPageId);
    blogPageUrl = runWpCli(["post", "url", blogPageId]);
    firstPostId = runWpCli([
      "post",
      "create",
      "--post_type=post",
      "--post_status=publish",
      "--post_title=Como organizar a rotina de estudos",
      "--post_content=Um roteiro prático para organizar a semana de estudos.",
      "--porcelain",
    ]);
    runWpCli([
      "post",
      "create",
      "--post_type=post",
      "--post_status=publish",
      "--post_title=Como revisar antes do simulado",
      "--post_content=Dicas para revisar sem perder o foco no edital.",
    ]);
  });

  test.afterAll(({}, testInfo) => {
    if (testInfo.project.name !== "chromium") {
      return;
    }

    setWpOption("show_on_front", "posts");
    setWpOption("page_on_front", "0");
    setWpOption("page_for_posts", "0");
  });

  test("renders the blog post index with article cards", async ({ page }) => {
    await page.goto(blogPageUrl);

    await expect(page.locator(".blog-header__title")).toHaveText("Artigos");
    await expect(page.locator(".post-card")).toHaveCount(2);
    await expect(page.locator(".post-card__media--placeholder")).toHaveCount(2);
    await expect(page.getByRole("link", { exact: true, name: "Como organizar a rotina de estudos" })).toBeVisible();
    await expect(page.locator(".entry-meta").first()).toBeVisible();
  });

  test("renders a single blog post with post navigation", async ({ page }) => {
    await page.goto(`/?p=${firstPostId}`);

    await expect(page.locator(".single-post-entry__title")).toHaveText("Como organizar a rotina de estudos");
    await expect(page.locator(".single-post-entry__content")).toContainText(
      "Um roteiro prático para organizar a semana de estudos.",
    );
    await expect(page.locator(".entry-meta")).toBeVisible();
    await expect(page.locator(".entry-taxonomy")).toBeVisible();
    await expect(page.locator(".post-navigation")).toBeVisible();
  });
});
