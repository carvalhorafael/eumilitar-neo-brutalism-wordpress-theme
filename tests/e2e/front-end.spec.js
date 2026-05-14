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

const cleanupE2eContent = () => {
  runWpCli([
    "eval",
    `
    $posts = get_posts(array(
      'fields' => 'ids',
      'numberposts' => -1,
      'post_status' => 'any',
      'post_type' => array('page', 'post'),
    ));
    foreach ($posts as $post_id) {
      $post_name = get_post_field('post_name', $post_id);
      if (0 === strpos($post_name, 'e2e-blog-')) {
        wp_delete_post($post_id, true);
      }
    }
    foreach (array('rotina-e2e', 'edital-e2e') as $slug) {
      $category = get_term_by('slug', $slug, 'category');
      if ($category) {
        wp_delete_term($category->term_id, 'category');
      }
      $tag = get_term_by('slug', $slug, 'post_tag');
      if ($tag) {
        wp_delete_term($tag->term_id, 'post_tag');
      }
    }
    `,
  ]);
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

  test("toggles the mobile navigation menu", async ({ page, isMobile }) => {
    test.skip(!isMobile, "The hamburger navigation is only visible on mobile.");

    await page.goto("/");

    const trigger = page.locator("[data-navbar-trigger]");
    const panel = page.locator("#primary-menu-panel");

    await expect(trigger).toBeVisible();
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
  let categoryUrl;
  let frontPageId;
  let firstPostId;
  let originalPageForPosts;
  let originalPageOnFront;
  let originalPostsPerPage;
  let originalShowOnFront;
  let tagUrl;

  test.beforeAll(({}, testInfo) => {
    if (testInfo.project.name !== "chromium") {
      return;
    }

    originalShowOnFront = tryRunWpCli(["option", "get", "show_on_front"]) || "posts";
    originalPageOnFront = tryRunWpCli(["option", "get", "page_on_front"]) || "0";
    originalPageForPosts = tryRunWpCli(["option", "get", "page_for_posts"]) || "0";
    originalPostsPerPage = tryRunWpCli(["option", "get", "posts_per_page"]) || "10";
    cleanupE2eContent();

    blogPageId = runWpCli([
      "post",
      "create",
      "--post_type=page",
      "--post_status=publish",
      "--post_title=Artigos E2E",
      "--post_name=e2e-blog-artigos",
      "--post_content=Conteúdos e orientações para sua preparação.",
      "--porcelain",
    ]);
    frontPageId = runWpCli([
      "post",
      "create",
      "--post_type=page",
      "--post_status=publish",
      "--post_title=Home E2E",
      "--post_name=e2e-blog-home",
      "--post_content=Página inicial temporária para testes.",
      "--porcelain",
    ]);

    setWpOption("show_on_front", "page");
    setWpOption("page_on_front", frontPageId);
    setWpOption("page_for_posts", blogPageId);
    setWpOption("posts_per_page", "2");
    blogPageUrl = runWpCli(["post", "url", blogPageId]);
    firstPostId = runWpCli([
      "post",
      "create",
      "--post_type=post",
      "--post_status=publish",
      "--post_title=Como organizar a rotina de estudos E2E",
      "--post_name=e2e-blog-como-organizar-a-rotina-de-estudos",
      "--post_content=Um roteiro prático para organizar a semana de estudos.",
      "--comment_status=open",
      "--porcelain",
    ]);
    runWpCli([
      "comment",
      "create",
      `--comment_post_ID=${firstPostId}`,
      "--comment_author=Aluno E2E",
      "--comment_author_email=aluno-e2e@example.com",
      "--comment_content=Esse roteiro ajudou a organizar a revisão.",
      "--comment_approved=1",
    ]);
    tryRunWpCli(["term", "create", "category", "Rotina E2E", "--slug=rotina-e2e"]);
    tryRunWpCli(["term", "create", "post_tag", "Edital E2E", "--slug=edital-e2e"]);
    runWpCli(["post", "term", "add", firstPostId, "category", "rotina-e2e"]);
    runWpCli(["post", "term", "add", firstPostId, "post_tag", "edital-e2e"]);
    categoryUrl = runWpCli(["eval", "echo get_term_link('rotina-e2e', 'category');"]);
    tagUrl = runWpCli(["eval", "echo get_term_link('edital-e2e', 'post_tag');"]);
    runWpCli([
      "post",
      "create",
      "--post_type=post",
      "--post_status=publish",
      "--post_title=Como revisar antes do simulado E2E",
      "--post_name=e2e-blog-como-revisar-antes-do-simulado",
      "--post_content=Dicas para revisar sem perder o foco no edital.",
    ]);
    runWpCli([
      "post",
      "create",
      "--post_type=post",
      "--post_status=publish",
      "--post_title=Como montar um ciclo de revisão E2E",
      "--post_name=e2e-blog-como-montar-um-ciclo-de-revisao",
      "--post_content=Um exemplo de ciclo para manter constância.",
    ]);
  });

  test.afterAll(({}, testInfo) => {
    if (testInfo.project.name !== "chromium") {
      return;
    }

    setWpOption("show_on_front", originalShowOnFront || "posts");
    setWpOption("page_on_front", originalPageOnFront || "0");
    setWpOption("page_for_posts", originalPageForPosts || "0");
    setWpOption("posts_per_page", originalPostsPerPage || "10");
    cleanupE2eContent();
  });

  test("renders the blog post index with article cards", async ({ page }) => {
    await page.goto(blogPageUrl);

    await expect(page.locator(".blog-header__title")).toHaveText("Artigos E2E");
    expect(await page.locator(".post-card").count()).toBeGreaterThanOrEqual(2);
    expect(await page.locator(".post-card__media--placeholder").count()).toBeGreaterThanOrEqual(2);
    await expect(page.locator(".post-card__title").first()).toBeVisible();
    await expect(page.locator(".entry-meta").first()).toBeVisible();
  });

  test("paginates the blog post index", async ({ page }) => {
    await page.goto(blogPageUrl);

    const pagination = page.locator(".posts-pagination");

    await expect(pagination).toBeVisible();
    await expect(pagination.locator("[aria-current='page']")).toHaveText("1");

    await pagination.getByRole("link", { name: "2" }).click();

    await expect(page.locator(".posts-pagination [aria-current='page']")).toHaveText("2");
    expect(await page.locator(".post-card").count()).toBeGreaterThanOrEqual(1);
  });

  test("renders recent posts on the front page", async ({ page }) => {
    await page.goto("/");

    await expect(page.locator(".home-recent-posts__title")).toHaveText("Artigos recentes");
    expect(await page.locator(".post-card-compact").count()).toBeGreaterThanOrEqual(2);
    expect(await page.locator(".post-card-compact").count()).toBeLessThanOrEqual(4);
    await expect(page.getByRole("link", { name: "Ver todos" })).toHaveAttribute("href", blogPageUrl);
    await expect(page.getByRole("link", { exact: true, name: "Como organizar a rotina de estudos E2E" })).toBeVisible();
  });

  test("renders a single blog post with post navigation", async ({ page }) => {
    await page.goto(`/?p=${firstPostId}`);

    await expect(page.locator(".single-post-entry__title")).toHaveText("Como organizar a rotina de estudos E2E");
    await expect(page.locator(".single-post-entry__content")).toContainText(
      "Um roteiro prático para organizar a semana de estudos.",
    );
    await expect(page.locator(".entry-meta")).toBeVisible();
    await expect(page.locator(".entry-taxonomy")).toBeVisible();
    await expect(page.locator(".post-navigation")).toBeVisible();
    await expect(page.locator(".comments-area")).toBeVisible();
    await expect(page.locator(".comment-list")).toContainText("Esse roteiro ajudou a organizar a revisão.");
    await expect(page.locator(".comment-reply-title")).toContainText("Deixe um comentário");
    await expect(page.locator("#comment")).toBeVisible();
  });

  test("renders category, tag and search editorial templates", async ({ page }) => {
    await page.goto(categoryUrl);

    await expect(page.locator(".blog-header__title")).toHaveText("Rotina E2E");
    await expect(page.getByRole("link", { exact: true, name: "Como organizar a rotina de estudos E2E" })).toBeVisible();

    await page.goto(tagUrl);

    await expect(page.locator(".blog-header__title")).toHaveText("Edital E2E");
    await expect(page.getByRole("link", { exact: true, name: "Como organizar a rotina de estudos E2E" })).toBeVisible();

    await page.goto("/?s=E2E");

    await expect(page.locator(".blog-header__title")).toContainText("Resultados para E2E");
    await expect(page.locator('form[role="search"]')).toBeVisible();

    await page.goto("/?s=resultado-inexistente-e2e");

    await expect(page.locator(".site-empty")).toBeVisible();
    await expect(page.locator(".site-empty")).toContainText("Nenhum resultado encontrado");
    await expect(page.getByRole("link", { name: "Ver todos os artigos" })).toHaveAttribute("href", blogPageUrl);
  });

  test("renders the 404 template with search and blog return", async ({ page }) => {
    await page.goto("/?p=999999999");

    await expect(page.locator(".error-page__title")).toHaveText("Página não encontrada");
    await expect(page.locator('form[role="search"]')).toBeVisible();
    await expect(page.getByRole("link", { name: "Ver artigos" })).toBeVisible();
  });
});
