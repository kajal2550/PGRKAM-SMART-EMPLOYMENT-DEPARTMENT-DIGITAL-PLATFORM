import ServiceCard from '../components/ServiceCard'
import { dummyServices } from '../utils/helpers'

export default function Services() {
  return (
    <div className="max-w-screen-xl mx-auto px-6 py-16">
      <div className="text-center mb-12">
        <span className="badge badge-blue mb-3">All Services</span>
        <h1 className="text-3xl font-extrabold text-gray-900">Employment Services</h1>
        <p className="text-gray-500 mt-3 max-w-xl mx-auto">
          PGRKAM offers a comprehensive range of employment and career development services
          for every citizen of Punjab.
        </p>
      </div>

      <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {dummyServices.map((s) => (
          <ServiceCard key={s.id} {...s} />
        ))}
      </div>

      {/* Government Schemes section */}
      <div className="mt-16">
        <h2 className="text-2xl font-extrabold text-gray-900 mb-6">Employment Schemes</h2>
        <div className="grid sm:grid-cols-2 gap-4">
          {[
            {
              title: 'Ghar Ghar Rozgar Scheme',
              desc:  'Punjab government initiative providing job placement assistance to unemployed youth.',
              tag:   'State Scheme',
            },
            {
              title: 'PM KAUSHAL VIKAS YOJANA',
              desc:  'Central government skill development scheme providing free short-term training.',
              tag:   'Central Scheme',
            },
            {
              title: 'Startup Punjab',
              desc:  'Entrepreneurship support with seed funding and mentorship for new ventures.',
              tag:   'Startup',
            },
            {
              title: 'Apprenticeship Scheme',
              desc:  'Learn while you earn – structured on-the-job training with monthly stipend.',
              tag:   'Apprenticeship',
            },
          ].map((s) => (
            <div key={s.title} className="glass-card p-5">
              <div className="flex items-start justify-between gap-3">
                <h3 className="font-bold text-gray-900">{s.title}</h3>
                <span className="badge badge-blue flex-shrink-0">{s.tag}</span>
              </div>
              <p className="text-sm text-gray-500 mt-2">{s.desc}</p>
              <button className="btn-primary text-sm mt-4">Learn More</button>
            </div>
          ))}
        </div>
      </div>
    </div>
  )
}
