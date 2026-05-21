import { FiLayers, FiExternalLink, FiCalendar, FiUsers, FiDollarSign, FiInfo } from 'react-icons/fi'

const schemes = [
  {
    id: 1,
    title: 'Pradhan Mantri Rojgar Protsahan Yojana (PMRPY)',
    category: 'Employment Generation',
    color: 'blue',
    body: "Government of India pays the full employer's EPF & EPS contribution (12%) for new employees for 3 years. Encourages employers to hire more workers and bring them into the formal sector.",
    eligibility: ['New employee earning ≤ ₹15,000/month', 'Aadhaar seeded UAN required', 'Applicable to EPFO-registered establishments'],
    deadline: 'Ongoing',
    beneficiaries: '1.21 crore+',
    link: 'https://pmrpy.gov.in',
  },
  {
    id: 2,
    title: 'Mukhyamantri Punjab Employment Generation Scheme',
    category: 'State Scheme',
    color: 'orange',
    body: 'Punjab government scheme providing interest-free/subsidized loans up to ₹5 lakhs for educated unemployed youth to start their own business or self-employment ventures.',
    eligibility: ['Punjab resident', 'Age 18–45 years', 'Minimum 8th pass', 'First-time borrower'],
    deadline: 'Ongoing',
    beneficiaries: '2,500+ per year',
    link: 'https://pgrkam.com',
  },
  {
    id: 3,
    title: 'PM SVANidhi (Street Vendor Scheme)',
    category: 'Self Employment',
    color: 'green',
    body: 'Provides working capital loans of ₹10,000 to ₹50,000 to street vendors who lost livelihoods due to COVID-19. Regular repayment leads to enhanced credit limits.',
    eligibility: ['Street vendors with vending certificate', 'Valid ID proof', 'Punjab municipality registered'],
    deadline: 'Ongoing',
    beneficiaries: '40 lakh+ nationally',
    link: 'https://pmsvanidhi.mohua.gov.in',
  },
  {
    id: 4,
    title: 'Apprenticeship Training Scheme (NATS)',
    category: 'Skill Training',
    color: 'purple',
    body: 'National Apprenticeship Training Scheme provides on-the-job training in government and private establishments. Stipend paid by employer + GOI. Certificate recognized nationally.',
    eligibility: ['Engineering/Diploma/Graduate pass-outs', 'Age: up to 35 years', 'Punjab domicile preferred for state quota'],
    deadline: 'Rolling admissions',
    beneficiaries: '5 lakh seats/year (national)',
    link: 'https://nats.education.gov.in',
  },
  {
    id: 5,
    title: 'Punjab Skill Development Mission (PSDM)',
    category: 'Skill Training',
    color: 'teal',
    body: 'Free skill training in 200+ trades under Pradhan Mantri Kaushal Vikas Yojana (PMKVY) for Punjab youth. Training in ITI trades, healthcare, retail, agriculture, IT, and more.',
    eligibility: ['Punjab resident', 'Age 15–45 years', 'Unemployed / dropout youth', 'SC/ST/Women get preference'],
    deadline: 'Batch-based enrollment',
    beneficiaries: '2 lakh+ per year',
    link: 'https://psdm.gov.in',
  },
  {
    id: 6,
    title: 'PM Rozgar Mela (PM-RM)',
    category: 'Government Jobs',
    color: 'red',
    body: 'Prime Minister directly distributes appointment letters to newly recruited central government employees. Mega drives conducted across India. Punjab youth can attend nearest Rozgar Mela.',
    eligibility: ['Selected candidates in central govt recruitment', 'Valid appointment/offer letter'],
    deadline: 'Event-based',
    beneficiaries: '10 lakh+ letters distributed',
    link: 'https://pmrozgarmela.com',
  },
  {
    id: 7,
    title: 'Gig/Platform Workers Welfare Fund (Punjab)',
    category: 'State Scheme',
    color: 'yellow',
    body: 'Punjab Government is setting up a welfare fund for gig workers (delivery agents, cab drivers, freelancers). Provides accident insurance, health coverage, and skill upgradation opportunities.',
    eligibility: ['Gig / platform workers registered in Punjab', 'Valid ID and gig platform registration'],
    deadline: 'Announced 2025 – Rolling',
    beneficiaries: '5 lakh gig workers in Punjab',
    link: 'https://labour.punjab.gov.in',
  },
  {
    id: 8,
    title: 'National Career Service (NCS) Portal',
    category: 'Employment Portal',
    color: 'indigo',
    body: 'National job portal by Ministry of Labour & Employment. Offers job matching, career counselling, skill courses, internships, apprenticeships and government scheme information at one place.',
    eligibility: ['Any Indian citizen', 'Free registration', 'Employers and job seekers both can register'],
    deadline: 'Ongoing',
    beneficiaries: '1.4 crore+ registered job seekers',
    link: 'https://ncs.gov.in',
  },
]

const colorMap = {
  blue:   'bg-blue-100 text-blue-700 border-blue-200',
  orange: 'bg-orange-100 text-orange-700 border-orange-200',
  green:  'bg-green-100 text-green-700 border-green-200',
  purple: 'bg-purple-100 text-purple-700 border-purple-200',
  teal:   'bg-teal-100 text-teal-700 border-teal-200',
  red:    'bg-red-100 text-red-700 border-red-200',
  yellow: 'bg-yellow-100 text-yellow-700 border-yellow-200',
  indigo: 'bg-indigo-100 text-indigo-700 border-indigo-200',
}

export default function Schemes() {
  return (
    <div className="max-w-4xl mx-auto space-y-6 animate-fade-in">
      {/* Header */}
      <div>
        <h1 className="text-2xl font-bold text-gray-900 flex items-center gap-2">
          <FiLayers size={22} /> Employment Schemes
        </h1>
        <p className="text-gray-500 mt-0.5 text-sm">
          Central &amp; Punjab Government employment schemes, subsidies, and skill programs you can apply for
        </p>
      </div>

      {/* Info banner */}
      <div className="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3">
        <FiInfo size={18} className="text-blue-500 flex-shrink-0 mt-0.5" />
        <p className="text-sm text-blue-700">
          <strong>Tip:</strong> Most schemes require Aadhaar, bank account, and domicile certificate. Visit your nearest <strong>PGRKAM District Employment Centre</strong> or the official portals linked below to apply.
        </p>
      </div>

      {/* Scheme cards */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
        {schemes.map(scheme => (
          <div key={scheme.id} className="glass-card p-5 flex flex-col gap-3 hover:shadow-md transition-shadow">
            <div className="flex items-start justify-between gap-2">
              <span className={`text-xs px-2.5 py-1 rounded-full font-medium border ${colorMap[scheme.color] || colorMap.blue}`}>
                {scheme.category}
              </span>
            </div>
            <h3 className="font-bold text-gray-900 text-base leading-snug">{scheme.title}</h3>
            <p className="text-sm text-gray-600 leading-relaxed">{scheme.body}</p>

            <div className="bg-gray-50 rounded-xl p-3 space-y-1">
              <p className="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Eligibility</p>
              {scheme.eligibility.map((e, i) => (
                <p key={i} className="text-xs text-gray-700 flex items-start gap-1.5">
                  <span className="text-green-500 font-bold mt-0.5">✓</span> {e}
                </p>
              ))}
            </div>

            <div className="flex items-center justify-between text-xs text-gray-500 pt-1">
              <span className="flex items-center gap-1"><FiCalendar size={11} /> {scheme.deadline}</span>
              <span className="flex items-center gap-1"><FiUsers size={11} /> {scheme.beneficiaries}</span>
            </div>

            <a
              href={scheme.link}
              target="_blank"
              rel="noopener noreferrer"
              className="flex items-center justify-center gap-1.5 w-full py-2 rounded-xl border border-primary-200 text-primary-600 text-sm font-medium hover:bg-primary-50 transition mt-auto"
            >
              Apply / Learn More <FiExternalLink size={13} />
            </a>
          </div>
        ))}
      </div>
    </div>
  )
}
