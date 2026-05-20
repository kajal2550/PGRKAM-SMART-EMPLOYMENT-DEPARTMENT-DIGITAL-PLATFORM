import { FiTarget, FiUsers, FiAward, FiGlobe } from 'react-icons/fi'

export default function About() {
  return (
    <div>
      {/* Hero */}
      <section className="bg-gradient-primary py-20 text-center px-6">
        <h1 className="text-4xl font-extrabold text-white mb-4">About PGRKAM</h1>
        <p className="text-white/70 max-w-2xl mx-auto text-lg">
          Punjab Government Rozgar Kendra & Employment Portal — empowering the state's workforce
          since 2018 with smart digital employment services.
        </p>
      </section>

      {/* Mission / Vision */}
      <section className="max-w-screen-xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-10">
        <div className="glass-card p-8">
          <div className="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mb-4">
            <FiTarget className="text-blue-700" size={24} />
          </div>
          <h2 className="text-xl font-extrabold text-gray-900 mb-3">Our Mission</h2>
          <p className="text-gray-600 leading-relaxed">
            To bridge the gap between job seekers and employment opportunities in Punjab through
            a technology-driven, transparent and accessible digital platform that reaches every
            corner of the state.
          </p>
        </div>
        <div className="glass-card p-8">
          <div className="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center mb-4">
            <FiGlobe className="text-green-700" size={24} />
          </div>
          <h2 className="text-xl font-extrabold text-gray-900 mb-3">Our Vision</h2>
          <p className="text-gray-600 leading-relaxed">
            A fully employed Punjab where every youth has access to quality livelihood
            opportunities, skill training and career guidance — regardless of their
            background or location.
          </p>
        </div>
      </section>

      {/* Stats */}
      <section className="bg-primary-900 py-16">
        <div className="max-w-screen-xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
          {[
            { v: '3 Lakh+', l: 'Registered Users' },
            { v: '50,000+', l: 'Jobs Listed'       },
            { v: '1,200+',  l: 'Training Programs' },
            { v: '22',      l: 'Districts Covered' },
          ].map(({ v, l }) => (
            <div key={l}>
              <p className="text-3xl font-extrabold text-white">{v}</p>
              <p className="text-primary-200 text-sm mt-1">{l}</p>
            </div>
          ))}
        </div>
      </section>

      {/* Team */}
      <section className="max-w-screen-xl mx-auto px-6 py-16">
        <h2 className="text-2xl font-extrabold text-gray-900 text-center mb-10">Our Leadership</h2>
        <div className="grid sm:grid-cols-3 gap-6">
          {[
            { name: 'Sh. Amritpal Singh IAS', role: 'Secretary, Employment Dept.', avatar: 'A' },
            { name: 'Ms. Simranjit Kaur IAS', role: 'Director, Employment',        avatar: 'S' },
            { name: 'Mr. Kulwinder Singh',    role: 'IT Head, PGRKAM Portal',      avatar: 'K' },
          ].map((p) => (
            <div key={p.name} className="glass-card p-6 text-center">
              <div className="w-16 h-16 rounded-full bg-primary-600 flex items-center justify-center
                              text-white text-2xl font-bold mx-auto mb-4">
                {p.avatar}
              </div>
              <p className="font-bold text-gray-900">{p.name}</p>
              <p className="text-sm text-gray-500 mt-1">{p.role}</p>
            </div>
          ))}
        </div>
      </section>
    </div>
  )
}
