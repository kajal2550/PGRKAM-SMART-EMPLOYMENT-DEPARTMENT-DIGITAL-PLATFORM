import { Link } from 'react-router-dom'
import { FiArrowRight, FiBriefcase, FiBookOpen, FiFileText, FiMessageCircle,
         FiStar, FiUsers, FiCheckCircle, FiTarget, FiAward, FiTrendingUp } from 'react-icons/fi'

const SERVICES = [
  {
    icon: '🏛️', color: 'blue', path: '/jobs',
    title: 'Government Jobs',
    tagline: 'Sarkari Naukri — Punjab & Central Govt',
    description: 'Access real-time government job notifications from Punjab Police, Revenue Dept., Health Dept., PSPCL, PPSC and all state departments.',
    highlights: ['25+ active vacancies', 'PPSC & PSSSB jobs', 'Updated daily', 'Direct apply'],
    badge: 'Most Popular',
    badgeColor: 'bg-blue-100 text-blue-700',
  },
  {
    icon: '🏢', color: 'indigo', path: '/jobs?type=private',
    title: 'Private Jobs',
    tagline: 'Corporate & Industry Opportunities',
    description: 'Explore private sector jobs from IT companies, manufacturing units, banks, hospitals and MNCs operating in Punjab.',
    highlights: ['IT & Software', 'Banking & Finance', 'Healthcare', 'Manufacturing'],
    badge: 'High Demand',
    badgeColor: 'bg-indigo-100 text-indigo-700',
  },
  {
    icon: '🎓', color: 'green', path: '/training',
    title: 'Skill Training',
    tagline: 'Free & Subsidised — Punjab Skill Mission',
    description: 'Government-sponsored short-term and long-term skill development programs. Learn a trade, get certified and earn better.',
    highlights: ['100% free for BPL', 'Certificate on completion', 'Multiple batches', 'Stipend available'],
    badge: 'Free Programs',
    badgeColor: 'bg-primary-100 text-primary-700',
  },
  {
    icon: '📄', color: 'orange', path: '/resume',
    title: 'Resume Builder',
    tagline: 'Professional CV in Minutes',
    description: 'Create an ATS-friendly professional resume tailored for government and private job applications. Export as PDF instantly.',
    highlights: ['ATS-friendly format', 'PDF export', 'Multiple templates', 'Auto-fill from profile'],
    badge: 'Free Tool',
    badgeColor: 'bg-orange-100 text-orange-700',
  },
  {
    icon: '💬', color: 'purple', path: '/counselling',
    title: 'Career Counselling',
    tagline: 'One-on-One Expert Guidance',
    description: 'Book personal sessions with experienced career counsellors. Get advice on career path, interview preparation, and skill gaps.',
    highlights: ['Free sessions', 'Expert counsellors', 'Online & offline', 'Interview prep'],
    badge: 'Book Free',
    badgeColor: 'bg-purple-100 text-purple-700',
  },
  {
    icon: '📋', color: 'red', path: '/schemes',
    title: 'Employment Schemes',
    tagline: 'Punjab & Central Govt Welfare',
    description: 'Explore state and central government employment welfare schemes — financial aid, subsidies, apprenticeship stipends and more.',
    highlights: ['Ghar Ghar Rozgar', 'PM Kaushal Vikas', 'Startup Punjab', 'Apprenticeship'],
    badge: 'Benefits',
    badgeColor: 'bg-red-100 text-red-700',
  },
]

const SCHEMES = [
  {
    icon: '🏠', tag: 'State Scheme', tagColor: 'bg-blue-100 text-blue-700',
    title: 'Ghar Ghar Rozgar Yojana',
    desc: 'Punjab government initiative providing job placement assistance to unemployed youth across all districts. Covers job fairs, skill mapping and direct employer connect.',
    benefits: ['Free job fair participation', 'Priority placement support', 'Career counselling included'],
    eligibility: 'Punjab domicile, Age 18–35',
  },
  {
    icon: '🛠️', tag: 'Central Scheme', tagColor: 'bg-primary-100 text-primary-700',
    title: 'PM Kaushal Vikas Yojana (PMKVY)',
    desc: 'Central government skill development scheme offering free short-term training in 300+ job roles with NSDC-certified trainers and placement support.',
    benefits: ['Free training (300+ trades)', '₹8,000 cash reward on certification', 'Placement assistance'],
    eligibility: 'Indian citizen, Min. 8th pass',
  },
  {
    icon: '🚀', tag: 'Startup', tagColor: 'bg-purple-100 text-purple-700',
    title: 'Startup Punjab',
    desc: 'Entrepreneurship ecosystem with seed funding, co-working spaces, mentorship and regulatory support for first-generation entrepreneurs in Punjab.',
    benefits: ['Up to ₹20L seed funding', 'Mentorship from IIT/IIM alumni', 'Tax exemptions for 3 years'],
    eligibility: 'Punjab resident, Innovative idea',
  },
  {
    icon: '🎓', tag: 'Apprenticeship', tagColor: 'bg-yellow-100 text-yellow-700',
    title: 'National Apprenticeship Scheme',
    desc: 'Learn while you earn — structured on-the-job training at registered companies with monthly stipend. Leads to NCVT/SCVT certification.',
    benefits: ['₹6,000–14,000/month stipend', 'Industry experience', 'Govt-recognised certificate'],
    eligibility: 'ITI/10th/12th pass, Age 14–21',
  },
  {
    icon: '💰', tag: 'Financial Aid', tagColor: 'bg-orange-100 text-orange-700',
    title: 'Punjab SC/BC Employment Loan',
    desc: 'Subsidised loans for SC/BC/OBC youth to start self-employment ventures. Interest subvention and capital subsidy from Punjab govt.',
    benefits: ['Loan up to ₹5 Lakh', '50% interest subvention', 'No collateral for small loans'],
    eligibility: 'SC/BC/OBC, Punjab domicile',
  },
  {
    icon: '👩‍💼', tag: 'Women Scheme', tagColor: 'bg-pink-100 text-pink-700',
    title: 'Punjab Mahila Rozgar Scheme',
    desc: 'Special employment and self-employment scheme for women of Punjab — skill training, micro-enterprise support and priority placement.',
    benefits: ['Free skill training', 'Priority in govt jobs', '₹25,000 business grant'],
    eligibility: 'Women, Age 18–45, Punjab',
  },
]

const STEPS = [
  { num: '01', icon: <FiUsers size={22} />, title: 'Register Free', desc: 'Create your PGRKAM account in 2 minutes — no fees, no paperwork.' },
  { num: '02', icon: <FiFileText size={22} />, title: 'Build Your Profile', desc: 'Fill your qualifications, skills and build a professional resume.' },
  { num: '03', icon: <FiBriefcase size={22} />, title: 'Browse & Apply', desc: 'Search government and private jobs filtered by location and type.' },
  { num: '04', icon: <FiAward size={22} />, title: 'Get Hired', desc: 'Track your applications and get shortlisted by top employers.' },
]

const colorMap = {
  blue:   'bg-blue-50 border-blue-100 text-blue-700',
  indigo: 'bg-indigo-50 border-indigo-100 text-indigo-700',
  green:  'bg-primary-50 border-primary-100 text-primary-700',
  orange: 'bg-orange-50 border-orange-100 text-orange-700',
  purple: 'bg-purple-50 border-purple-100 text-purple-700',
  red:    'bg-red-50 border-red-100 text-red-700',
}

const iconBg = {
  blue:   'bg-blue-100',
  indigo: 'bg-indigo-100',
  green:  'bg-primary-100',
  orange: 'bg-orange-100',
  purple: 'bg-purple-100',
  red:    'bg-red-100',
}

export default function Services() {
  return (
    <div className="max-w-screen-xl mx-auto px-4 sm:px-6 py-10">

      {/* ── Hero ───────────────────────────────────────────────── */}
      <div className="rounded-3xl bg-gradient-to-br from-primary-700 via-primary-600 to-indigo-600 text-white px-8 py-14 text-center mb-14 relative overflow-hidden">
        <div className="absolute inset-0 opacity-10" style={{backgroundImage:'radial-gradient(circle at 20% 50%, white 1px, transparent 1px), radial-gradient(circle at 80% 20%, white 1px, transparent 1px)', backgroundSize:'40px 40px'}} />
        <span className="inline-block bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-wide">Punjab Govt Employment Portal</span>
        <h1 className="text-4xl sm:text-5xl font-extrabold mb-4 leading-tight">All Employment Services</h1>
        <p className="text-white/80 text-lg max-w-2xl mx-auto mb-8">
          PGRKAM brings government jobs, skill training, career counselling and welfare schemes — all under one roof for every citizen of Punjab.
        </p>
        <div className="flex flex-wrap justify-center gap-8">
          {[['500+','Job Listings'],['15+','Training Programs'],['6','Welfare Schemes'],['Free','All Services']].map(([num, label]) => (
            <div key={label} className="text-center">
              <div className="text-3xl font-extrabold">{num}</div>
              <div className="text-white/70 text-sm">{label}</div>
            </div>
          ))}
        </div>
      </div>

      {/* ── Service Cards ──────────────────────────────────────── */}
      <div className="mb-14">
        <div className="text-center mb-10">
          <h2 className="text-3xl font-extrabold text-gray-900">Our Services</h2>
          <p className="text-gray-500 mt-2 max-w-xl mx-auto">Everything you need for your career — completely free for Punjab citizens.</p>
        </div>
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {SERVICES.map((s) => (
            <Link
              key={s.title}
              to={s.path}
              className={`group rounded-2xl border p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col ${colorMap[s.color]}`}
            >
              <div className="flex items-start justify-between mb-4">
                <div className={`w-14 h-14 rounded-2xl ${iconBg[s.color]} flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300`}>
                  {s.icon}
                </div>
                <span className={`text-xs font-bold px-2.5 py-1 rounded-full ${s.badgeColor}`}>{s.badge}</span>
              </div>
              <h3 className="text-lg font-extrabold text-gray-900 mb-0.5">{s.title}</h3>
              <p className="text-xs font-semibold text-gray-400 mb-3 uppercase tracking-wide">{s.tagline}</p>
              <p className="text-sm text-gray-600 leading-relaxed mb-4 flex-1">{s.description}</p>
              <ul className="space-y-1.5 mb-5">
                {s.highlights.map(h => (
                  <li key={h} className="flex items-center gap-2 text-xs text-gray-600">
                    <FiCheckCircle size={13} className="text-primary-500 flex-shrink-0" />
                    {h}
                  </li>
                ))}
              </ul>
              <div className="flex items-center gap-1 text-sm font-semibold group-hover:gap-2 transition-all duration-200">
                Explore <FiArrowRight size={14} />
              </div>
            </Link>
          ))}
        </div>
      </div>

      {/* ── How It Works ──────────────────────────────────────── */}
      <div className="bg-gray-50 rounded-3xl px-8 py-12 mb-14">
        <div className="text-center mb-10">
          <h2 className="text-3xl font-extrabold text-gray-900">How It Works</h2>
          <p className="text-gray-500 mt-2">Get your dream job in 4 simple steps</p>
        </div>
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {STEPS.map((step, i) => (
            <div key={step.num} className="relative text-center">
              {i < STEPS.length - 1 && (
                <div className="hidden lg:block absolute top-8 left-[calc(50%+2.5rem)] w-[calc(100%-5rem)] h-0.5 bg-primary-200" />
              )}
              <div className="w-16 h-16 rounded-2xl bg-primary-600 text-white flex items-center justify-center mx-auto mb-4 shadow-lg">
                {step.icon}
              </div>
              <div className="text-xs font-bold text-primary-400 mb-1">{step.num}</div>
              <h3 className="font-extrabold text-gray-900 mb-2">{step.title}</h3>
              <p className="text-sm text-gray-500 leading-relaxed">{step.desc}</p>
            </div>
          ))}
        </div>
      </div>

      {/* ── Employment Schemes ────────────────────────────────── */}
      <div className="mb-14">
        <div className="text-center mb-10">
          <span className="inline-block bg-primary-100 text-primary-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">Government Welfare</span>
          <h2 className="text-3xl font-extrabold text-gray-900">Employment Schemes</h2>
          <p className="text-gray-500 mt-2 max-w-xl mx-auto">Punjab & Central Government schemes to support your career and livelihood.</p>
        </div>
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {SCHEMES.map((s) => (
            <div key={s.title} className="glass-card p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
              <div className="flex items-start justify-between mb-4">
                <span className="text-3xl">{s.icon}</span>
                <span className={`text-xs font-bold px-2.5 py-1 rounded-full ${s.tagColor}`}>{s.tag}</span>
              </div>
              <h3 className="font-extrabold text-gray-900 text-base mb-2">{s.title}</h3>
              <p className="text-sm text-gray-500 leading-relaxed mb-4 flex-1">{s.desc}</p>
              <div className="mb-4">
                <p className="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Key Benefits</p>
                <ul className="space-y-1.5">
                  {s.benefits.map(b => (
                    <li key={b} className="flex items-center gap-2 text-xs text-gray-700">
                      <FiCheckCircle size={12} className="text-primary-500 flex-shrink-0" />
                      {b}
                    </li>
                  ))}
                </ul>
              </div>
              <div className="pt-3 border-t border-gray-100 flex items-center justify-between">
                <div>
                  <p className="text-xs text-gray-400">Eligibility</p>
                  <p className="text-xs font-semibold text-gray-700">{s.eligibility}</p>
                </div>
                <Link to="/schemes" className="btn-primary text-xs px-3 py-1.5">Apply Now</Link>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* ── CTA Banner ─────────────────────────────────────────── */}
      <div className="rounded-3xl bg-gradient-to-r from-primary-600 to-primary-800 text-white px-8 py-12 text-center">
        <FiTrendingUp size={40} className="mx-auto mb-4 opacity-80" />
        <h2 className="text-3xl font-extrabold mb-3">Ready to Start Your Career Journey?</h2>
        <p className="text-white/80 text-lg mb-8 max-w-xl mx-auto">
          Join 50,000+ Punjab youth who have found employment through PGRKAM. Register free today.
        </p>
        <div className="flex flex-wrap justify-center gap-4">
          <Link to="/register" className="bg-white text-primary-700 font-bold px-8 py-3 rounded-xl hover:shadow-lg transition hover:-translate-y-0.5">
            Register Free
          </Link>
          <Link to="/jobs" className="bg-white/20 text-white font-bold px-8 py-3 rounded-xl border border-white/30 hover:bg-white/30 transition">
            Browse Jobs
          </Link>
        </div>
      </div>

    </div>
  )
}

