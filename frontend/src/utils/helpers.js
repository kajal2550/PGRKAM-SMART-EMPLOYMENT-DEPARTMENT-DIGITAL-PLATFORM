/**
 * Smart guidance keyword → module mapping.
 * Returns an array of suggestion objects based on the user's query.
 */
export const GUIDANCE_KEYWORDS = [
  {
    keywords: ['job', 'jobs', 'employment', 'work', 'vacancy', 'sarkari', 'govt', 'government',
               'naukri', 'nokri', 'kaam', 'rozgar', 'rojgar', 'position', 'opening', 'hiring'],
    module:   'Government Jobs',
    path:     '/jobs',
    icon:     '🏛️',
    color:    'blue',
    description: 'Browse government and public sector job openings.',
  },
  {
    keywords: ['private', 'company', 'corporate', 'mnc', 'startup', 'industry', 'sector'],
    module:   'Private Jobs',
    path:     '/jobs?type=private',
    icon:     '🏢',
    color:    'indigo',
    description: 'Explore private sector and corporate job opportunities.',
  },
  {
    keywords: ['skill', 'training', 'course', 'learn', 'certificate', 'trade', 'vocational',
               'sikhna', 'seekhna', 'padhai', 'coaching', 'class', 'workshop', 'program'],
    module:   'Skill Training',
    path:     '/training',
    icon:     '🎓',
    color:    'green',
    description: 'Enroll in government-sponsored skill development programs.',
  },
  {
    keywords: ['resume', 'cv', 'biodata', 'profile', 'portfolio', 'bio data'],
    module:   'Resume Builder',
    path:     '/resume',
    icon:     '📄',
    color:    'orange',
    description: 'Create and manage your professional resume.',
  },
  {
    keywords: ['career', 'counsel', 'counselling', 'guide', 'advice', 'mentor', 'direction',
               'salah', 'guidance', 'help me choose', 'what to do', 'kya karu', 'future'],
    module:   'Career Counselling',
    path:     '/counselling',
    icon:     '💬',
    color:    'purple',
    description: 'Get personalized career guidance from experts.',
  },
  {
    keywords: ['scheme', 'yojana', 'loan', 'subsidy', 'benefit', 'sarkari yojana', 'government scheme',
               'pmrpy', 'svnidhi', 'psdm', 'apprenticeship'],
    module:   'Employment Schemes',
    path:     '/schemes',
    icon:     '📋',
    color:    'teal',
    description: 'Explore Punjab & central government employment schemes.',
  },
  {
    keywords: ['apply', 'application', 'applied', 'my application', 'status', 'track'],
    module:   'My Applications',
    path:     '/my-applications',
    icon:     '📝',
    color:    'blue',
    description: 'Track your job applications and their status.',
  },
  {
    keywords: ['notification', 'alert', 'update', 'news'],
    module:   'Notifications',
    path:     '/notifications',
    icon:     '🔔',
    color:    'yellow',
    description: 'View your latest alerts and updates.',
  },
]

// Greeting patterns
const GREETINGS = ['hi', 'hlo', 'hello', 'hey', 'helo', 'hii', 'hiii', 'namaste', 'namaskar',
                   'sat sri akal', 'waheguru', 'good morning', 'good evening', 'good afternoon',
                   'sup', 'howdy', 'yo', 'hy', 'hlw', 'hlloo', 'helo']

// Help / intro patterns
const HELP_PATTERNS = ['help', 'what can you do', 'kya kar sakte', 'features', 'services',
                       'kya hai', 'batao', 'bato', 'tell me', 'intro', 'about']

/**
 * Smart chatbot response generator — handles greetings, help requests, and keyword matching.
 * Returns { reply: string, suggestions: Array }
 */
export function smartReply(message) {
  const lower = message.toLowerCase().trim()

  // 1. Greeting
  if (GREETINGS.some(g => lower === g || lower.startsWith(g + ' ') || lower.endsWith(' ' + g))) {
    return {
      reply: "👋 Hello! Welcome to PGRKAM — Punjab's Smart Employment Portal.\n\nI can help you with:\n• Finding government & private jobs\n• Skill training programs\n• Building your resume\n• Career counselling\n• Employment schemes\n\nWhat are you looking for today?",
      suggestions: [],
    }
  }

  // 2. Help / what can you do
  if (HELP_PATTERNS.some(p => lower.includes(p))) {
    return {
      reply: "Here's what I can help you with:",
      suggestions: GUIDANCE_KEYWORDS.slice(0, 5),
    }
  }

  // 3. Keyword analysis
  const matches = analyseQuery(message)
  if (matches.length) {
    const replies = {
      job:      "Great! Here are the job-related sections for you:",
      training: "Here are the training programs available:",
      resume:   "Let me help you with your resume:",
      career:   "Here are career guidance options:",
    }
    const firstType = matches[0]?.path?.includes('training') ? 'training'
      : matches[0]?.path?.includes('resume') ? 'resume'
      : matches[0]?.path?.includes('counsel') ? 'career' : 'job'
    return {
      reply: replies[firstType] || 'Based on your query, here are the relevant services:',
      suggestions: matches,
    }
  }

  // 4. Short/unknown input
  if (lower.length < 4) {
    return {
      reply: "Hmm, could you be a bit more specific? 😊 Try typing what you need — for example:\n• \"I need a government job\"\n• \"Show me training courses\"\n• \"Help with resume\"",
      suggestions: [],
    }
  }

  // 5. Default fallback
  return {
    reply: "I didn't quite understand that. Here are some things I can help you with:",
    suggestions: GUIDANCE_KEYWORDS.slice(0, 4),
  }
}

/**
 * Analyse the user message and return matching guidance suggestions.
 * @param {string} message
 * @returns {Array}
 */
export function analyseQuery(message) {
  const lower = message.toLowerCase()
  const matches = []

  for (const item of GUIDANCE_KEYWORDS) {
    if (item.keywords.some((kw) => lower.includes(kw))) {
      if (!matches.find((m) => m.path === item.path)) {
        matches.push(item)
      }
    }
  }

  return matches
}

/**
 * Format a date string to a readable locale format.
 * @param {string} dateStr
 * @returns {string}
 */
export function formatDate(dateStr) {
  if (!dateStr) return '—'
  return new Intl.DateTimeFormat('en-IN', {
    day:   '2-digit',
    month: 'short',
    year:  'numeric',
  }).format(new Date(dateStr))
}

/**
 * Truncate a string to the given length.
 * @param {string} str
 * @param {number} max
 * @returns {string}
 */
export function truncate(str, max = 100) {
  if (!str) return ''
  return str.length > max ? str.slice(0, max) + '…' : str
}

/**
 * Return Tailwind colour classes for a given colour name.
 * @param {string} color
 * @returns {{ bg: string, text: string, border: string }}
 */
export function colorClasses(color) {
  const map = {
    blue:   { bg: 'bg-blue-100',   text: 'text-blue-700',   border: 'border-blue-200'   },
    indigo: { bg: 'bg-indigo-100', text: 'text-indigo-700', border: 'border-indigo-200' },
    green:  { bg: 'bg-green-100',  text: 'text-green-700',  border: 'border-green-200'  },
    orange: { bg: 'bg-orange-100', text: 'text-orange-700', border: 'border-orange-200' },
    purple: { bg: 'bg-purple-100', text: 'text-purple-700', border: 'border-purple-200' },
    red:    { bg: 'bg-red-100',    text: 'text-red-700',    border: 'border-red-200'    },
  }
  return map[color] || map.blue
}

/**
 * Dummy data generators used when the backend is unavailable.
 */
export const dummyJobs = [
  { id: 1, title: 'Junior Clerk',           department: 'Revenue Dept.',         location: 'Chandigarh', type: 'government', salary: '₹25,000 – ₹35,000', deadline: '2026-06-30', posted: '2026-05-01' },
  { id: 2, title: 'Software Developer',     department: 'Punjab IT Department',   location: 'Mohali',     type: 'government', salary: '₹45,000 – ₹65,000', deadline: '2026-07-15', posted: '2026-05-05' },
  { id: 3, title: 'Data Entry Operator',    department: 'Health Dept.',           location: 'Ludhiana',   type: 'government', salary: '₹18,000 – ₹22,000', deadline: '2026-06-20', posted: '2026-05-08' },
  { id: 4, title: 'Frontend Engineer',      department: 'TechCorp Pvt. Ltd.',     location: 'Mohali',     type: 'private',    salary: '₹40,000 – ₹70,000', deadline: '2026-06-25', posted: '2026-05-10' },
  { id: 5, title: 'Customer Support Exec.', department: 'BPO Solutions Ltd.',     location: 'Amritsar',   type: 'private',    salary: '₹15,000 – ₹25,000', deadline: '2026-06-18', posted: '2026-05-12' },
  { id: 6, title: 'Electrician',            department: 'PSPCL',                  location: 'Patiala',    type: 'government', salary: '₹20,000 – ₹30,000', deadline: '2026-07-01', posted: '2026-05-03' },
]

export const dummyTrainings = [
  { id: 1, title: 'Web Development Bootcamp',   provider: 'Punjab Skill Mission', duration: '3 months', seats: 30, enrolled: 18, category: 'IT',           fee: 'Free' },
  { id: 2, title: 'Electrician Trade Course',   provider: 'ITI Ludhiana',         duration: '6 months', seats: 25, enrolled: 25, category: 'Electrical',   fee: 'Free' },
  { id: 3, title: 'Digital Marketing',          provider: 'CDAC Mohali',          duration: '2 months', seats: 40, enrolled: 22, category: 'Marketing',    fee: '₹500' },
  { id: 4, title: 'Tailoring & Garment Making', provider: 'Women Empowerment ITI', duration: '4 months', seats: 20, enrolled: 15, category: 'Handcraft',  fee: 'Free' },
  { id: 5, title: 'Spoken English & Soft Skills',provider: 'PGRKAM Centre',       duration: '1 month',  seats: 50, enrolled: 30, category: 'Communication', fee: 'Free' },
]

export const dummyServices = [
  { id: 1, title: 'Government Jobs',      icon: '🏛️', color: 'blue',   path: '/jobs',        description: 'Latest government job notifications across Punjab departments.' },
  { id: 2, title: 'Private Jobs',         icon: '🏢', color: 'indigo', path: '/jobs?type=private', description: 'Private sector opportunities from top recruiters.' },
  { id: 3, title: 'Skill Training',       icon: '🎓', color: 'green',  path: '/training',    description: 'Free and subsidised skill development programs.' },
  { id: 4, title: 'Resume Builder',       icon: '📄', color: 'orange', path: '/resume',      description: 'Build a professional resume in minutes.' },
  { id: 5, title: 'Career Counselling',   icon: '💬', color: 'purple', path: '/counselling', description: 'One-on-one guidance sessions with career experts.' },
  { id: 6, title: 'Employment Schemes',   icon: '📋', color: 'red',    path: '/services',    description: 'State and central government employment welfare schemes.' },
]
