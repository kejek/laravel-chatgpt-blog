export default function handler(request, response) {
	const authHeader = request.headers.get('authorization');
	if (authHeader !== `Bearer ${process.env.CRON_SECRET}`) {
	  return response.json(
		{ success: false },
		{
		  status: 401,
		},
	  );
	}
   
	return response.json({ success: true });
  }