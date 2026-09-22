export function isSuccessfulApplication(search = '') {
    return new URLSearchParams(search).get('applied') === '1';
}

export function buildJobApplicationNextStep(jobSlug = '') {
    const encodedJob = encodeURIComponent(String(jobSlug).trim());
    return {
        question: 'Does your CV clearly show that you match this JD?',
        assessmentPath: `/services/cv-assessment?job=${encodedJob}&utm_source=job_application_success&utm_medium=website&utm_campaign=cv_jd_match`,
        rebuildPath: '/services/professional-cv-rebuild?utm_source=job_application_success&utm_medium=website&utm_campaign=cv_jd_match_rebuild',
        skipPath: '/jobs',
        independenceNote: 'This is an optional paid professional service. It is separate from your job application and does not affect shortlisting.',
    };
}

function activatePostApplicationStep() {
    const panel = document.querySelector('[data-job-application-next-step]');
    if (!panel || !isSuccessfulApplication(window.location.search)) return;

    const step = buildJobApplicationNextStep(panel.dataset.jobSlug || '');
    const form = document.querySelector('[data-job-application-form]');
    const question = panel.querySelector('[data-next-step-question]');
    const assessment = panel.querySelector('[data-assessment-link]');
    const rebuild = panel.querySelector('[data-rebuild-link]');
    const skip = panel.querySelector('[data-skip-link]');
    const note = panel.querySelector('[data-independence-note]');

    if (form) form.hidden = true;
    if (question) question.textContent = step.question;
    if (assessment) assessment.href = step.assessmentPath;
    if (rebuild) rebuild.href = step.rebuildPath;
    if (skip) skip.href = step.skipPath;
    if (note) note.textContent = step.independenceNote;
    panel.hidden = false;
    panel.focus({ preventScroll: true });
}

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', activatePostApplicationStep, { once: true });
    } else {
        activatePostApplicationStep();
    }
}
