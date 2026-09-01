# HiredNext Lyzr → Slack Revenue Bridge

## Purpose

This bridge makes the existing HiredNext Lyzr agents callable from the HiredNext Slack revenue rooms. A Slack message is verified, classified, sent to the correct Lyzr agent, and the response is posted back into the same Slack thread.

## Production endpoint

`POST https://hirednext.net/webhooks/slack/revenue-council`

## Existing Lyzr agents reused automatically

The bridge reads the same production registry already used by the CV assessment engine:

`WRITEPATH/cv/lyzr-agents.json`

Supported registry keys:

- `openai_recruiter` — OpenAI Recruiter / ATS Reviewer
- `claude_critic` — Claude Critical Career Reviewer
- `gemini_rolefit` — Gemini Role-Fit Reviewer

No duplicate CV agents are created.

## Required production environment values

```dotenv
LYZR_API_KEY=<existing production Lyzr key>
SLACK_SIGNING_SECRET=<Slack app Signing Secret>
SLACK_BOT_TOKEN=<Slack bot token beginning xoxb->
SLACK_REVENUE_CHANNEL_IDS=C0BTXLQDHEF,C0BTZP75LRK,C0BU7JC1WJ0,C0BU5RF1N7K
```

Optional Revenue Council agents can be added one by one without changing code:

```dotenv
LYZR_REVENUE_CEO_AGENT_ID=<agent id>
LYZR_SIGNALS_AGENT_ID=<agent id>
LYZR_CANDIDATE_REVENUE_AGENT_ID=<agent id>
```

## Slack app install

Create the Slack app from:

`docs/integrations/hirednext-revenue-council-slack-manifest.json`

Install it to the HiredNext workspace. Copy the Bot User OAuth Token into `SLACK_BOT_TOKEN` and the app Signing Secret into `SLACK_SIGNING_SECRET`.

Invite the app to these private channels:

- `#hn-revenue-war-room`
- `#hn-sales-pipeline`
- `#hn-growth-marketing`
- `#hn-operations-alerts`

## Routing behaviour

Messages containing `cv`, `resume`, `candidate`, `ats`, `599`, or `assessment` are routed to all configured existing CV Lyzr reviewers.

Messages containing funding/GCC/semiconductor/expansion/leadership/IPO signal terms route to `LYZR_SIGNALS_AGENT_ID` once configured.

Everything else routes to `LYZR_REVENUE_CEO_AGENT_ID` once configured.

If a Revenue Council agent is not configured, Slack receives a clear configuration warning rather than silently failing.

## Safety and duplicate controls

- Slack request signatures are verified with the Slack Signing Secret.
- Requests older than five minutes are rejected.
- Bot-authored messages are ignored, preventing bot loops.
- Only configured HiredNext revenue channel IDs are accepted.
- Slack retry `event_id` values are deduplicated for 24 hours.
- Secrets are environment-only and are not stored in GitHub.

## First live test

After deployment and Slack installation, send this in `#hn-revenue-war-room`:

`CV assessment test — can the three HiredNext reviewers answer here?`

Expected result: one threaded Slack response with labelled sections for the configured OpenAI Recruiter / ATS Reviewer, Claude Critical Career Reviewer, and Gemini Role-Fit Reviewer.
